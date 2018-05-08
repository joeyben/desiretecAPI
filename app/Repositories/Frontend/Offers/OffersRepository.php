<?php

namespace App\Repositories\Frontend\Offers;

use App\Events\Frontend\Offers\OfferCreated;
use App\Events\Frontend\Offers\OfferDeleted;
use App\Events\Frontend\Offers\OfferUpdated;
use App\Exceptions\GeneralException;
use App\Models\Offers\Offer;
use App\Repositories\BaseRepository;
use DB;
use Illuminate\Support\Facades\Storage;

/**
 * Class OffersRepository.
 */
class OffersRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Offer::class;

    protected $upload_path;

    /**
     * Storage Class Object.
     *
     * @var \Illuminate\Support\Facades\Storage
     */
    protected $storage;

    public function __construct()
    {
        $this->upload_path = 'img'.DIRECTORY_SEPARATOR.'offer'.DIRECTORY_SEPARATOR;
        $this->storage = Storage::disk('s3');
    }

    /**
     * @return mixed
     */
    public function getForDataTable()
    {
        return $this->query()
            ->leftjoin(config('access.users_table'), config('access.users_table').'.id', '=', config('module.offers.table').'.created_by')
            ->leftjoin(config('module.wishes.table'), config('module.wishes.table').'.id', '=', config('module.offers.table').'.wish_id')
            ->select([
                config('module.offers.table').'.id',
                config('module.offers.table').'.title',
                config('module.offers.table').'.status',
                config('module.offers.table').'.created_by',
                config('module.offers.table').'.created_at',
                config('access.users_table').'.first_name as first_name',
                config('access.users_table').'.last_name as last_name',
                config('module.wishes.table').'.id as wish_id',
                config('module.wishes.table').'.title as wish_title',
            ])->where(config('module.offers.table').'.created_by', access()->user()->id);
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function getForDataTableForWish($id)
    {
        return $this->query()
            ->leftjoin(config('access.users_table'), config('access.users_table').'.id', '=', config('module.offers.table').'.created_by')
            ->leftjoin(config('module.wishes.table'), config('module.wishes.table').'.id', '=', config('module.offers.table').'.wish_id')
            ->select([
                config('module.offers.table').'.id',
                config('module.offers.table').'.title',
                config('module.offers.table').'.status',
                config('module.offers.table').'.created_by',
                config('module.offers.table').'.created_at',
                config('access.users_table').'.first_name as first_name',
                config('access.users_table').'.last_name as last_name',
                config('module.wishes.table').'.id as wish_id',
                config('module.wishes.table').'.title as wish_title',
            ])->where(config('module.offers.table').'.wish_id', $id);
    }

    /**
     * @param array $input
     *
     * @throws \App\Exceptions\GeneralException
     *
     * @return bool
     */
    public function create(array $input)
    {

        DB::transaction(function () use ($input) {
            $input = $this->uploadImage($input);
            $input['created_by'] = access()->user()->id;

            if ($offer = Offer::create($input)) {

                event(new OfferCreated($offer));

                return true;
            }

            throw new GeneralException(trans('exceptions.backend.offers.create_error'));
        });
    }

    /**
     * Update Offer.
     *
     * @param \App\Models\Offers\Offer $offer
     * @param array                  $input
     */
    public function update(Offer $offer, array $input)
    {
        $input['updated_by'] = access()->user()->id;

        // Uploading Image
        if (array_key_exists('file', $input)) {
            $this->deleteOldFile($offer);
            $input = $this->uploadImage($input);
        }

        DB::transaction(function () use ($offer, $input) {
            if ($offer->update($input)) {

                event(new OfferUpdated($offer));

                return true;
            }

            throw new GeneralException(
                trans('exceptions.backend.offers.update_error')
            );
        });
    }



    /**
     * @param \App\Models\Offers\Offer $offer
     *
     * @throws GeneralException
     *
     * @return bool
     */
    public function delete(Offer $offer)
    {
        DB::transaction(function () use ($offer) {
            if ($offer->delete()) {
                event(new OfferDeleted($offer));

                return true;
            }

            throw new GeneralException(trans('exceptions.backend.offers.delete_error'));
        });
    }

    /**
     * Upload Image.
     *
     * @param array $input
     *
     * @return array $input
     */
    public function uploadImage($input)
    {
        $avatar = $input['file'];

        if (isset($input['file']) && !empty($input['file'])) {
            $fileName = time().$avatar->getClientOriginalName();

            $this->storage->put($this->upload_path.$fileName, file_get_contents($avatar->getRealPath()));

            $input = array_merge($input, ['file' => $fileName]);

            return $input;
        }
    }

    /**
     * Destroy Old Image.
     *
     * @param int $id
     */
    public function deleteOldFile($model)
    {
        $fileName = $model->file;

        return $this->storage->delete($this->upload_path.$fileName);
    }
}
