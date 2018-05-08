<?php

namespace App\Repositories\Frontend\Wishes;

use App\Events\Frontend\Wishes\WishCreated;
use App\Events\Frontend\Wishes\WishDeleted;
use App\Events\Frontend\Wishes\WishUpdated;
use App\Exceptions\GeneralException;
use App\Models\Wishes\Wish;
use App\Repositories\BaseRepository;
use DB;
use Illuminate\Support\Facades\Storage;

/**
 * Class WishesRepository.
 */
class WishesRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Wish::class;

    const ROUND_ROBIN = 'round-robin';
    const REGIONAL = 'regional';

    protected $upload_path;

    /**
     * Storage Class Object.
     *
     * @var \Illuminate\Support\Facades\Storage
     */
    protected $storage;

    public function __construct()
    {
        $this->upload_path = 'img'.DIRECTORY_SEPARATOR.'wish'.DIRECTORY_SEPARATOR;
        $this->storage = Storage::disk('s3');
    }

    /**
     * @return mixed
     */
    public function getForDataTable()
    {
        $whitelabels = [];
        foreach (access()->user()->whitelabels as $whitelabel) {
            array_push($whitelabels, $whitelabel->id);
        }



        $query = $this->query()
            ->leftjoin(config('access.users_table'), config('access.users_table').'.id', '=', config('module.wishes.table').'.created_by')
            ->leftjoin(config('module.whitelabels.table'), config('module.whitelabels.table').'.id', '=', config('module.wishes.table').'.whitelabel_id')
            ->leftjoin(config('module.offers.table'), config('module.offers.table').'.wish_id', '=', config('module.wishes.table').'.id')
            ->select([
                config('module.wishes.table').'.id',
                config('module.wishes.table').'.title',
                config('module.wishes.table').'.airport',
                config('module.wishes.table').'.destination',
                config('module.wishes.table').'.duration',
                config('module.wishes.table').'.adults',
                config('module.wishes.table').'.budget',
                config('module.wishes.table').'.earliest_start',
                config('module.wishes.table').'.latest_return',
                config('module.wishes.table').'.status',
                config('module.wishes.table').'.featured_image',
                config('module.wishes.table').'.created_by',
                config('module.wishes.table').'.created_at',
                config('module.wishes.table').'.group_id',
                config('access.users_table').'.first_name as first_name',
                config('access.users_table').'.last_name as last_name',
                config('module.whitelabels.table').'.id as whitelabel_id',
                config('module.whitelabels.table').'.display_name as whitelabel_name',
                DB::raw('count('.config('module.offers.table').'.id) as offers'),
            ])
            ->whereIn('whitelabel_id',$whitelabels)
            ->groupBy(config('module.wishes.table').'.id');
        if(access()->user()->hasRole('User')){
            $query->where(config('module.wishes.table').'.created_by', access()->user()->id);
        }else if(access()->user()->hasRole('Seller')){
            $query->whereIn(config('module.wishes.table').'.group_id', access()->user()->groups->pluck('id')->toArray());
        }

        return $query;
    }

    /**
     * @return mixed
     */
    public function getLowestWishesGroup($whitelabel_id){

        $query = $this->query()
            ->select(config('module.wishes.table').'.group_id', DB::raw('count(*) as total'))
            ->where('whitelabel_id',$whitelabel_id)
            ->where(config('module.wishes.table').'.group_id', '!=', 0)
            ->groupBy(config('module.wishes.table').'.group_id')
            ->orderBy('total','ASC')
            ->get();

        $group_id = count($query->toArray()) > 0 ? $query->toArray()[0]['group_id'] : 0;

        return $group_id;
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
            $input['whitelabel_id'] = access()->user()->getWhitelabels()[0];
            $input['group_id'] = $this->getGroup();

            if ($wish = Wish::create($input)) {

                event(new WishCreated($wish));

                return true;
            }

            throw new GeneralException(trans('exceptions.backend.wishes.create_error'));
        });
    }

    /**
     * Update Wish.
     *
     * @param \App\Models\Wishes\Wish $wish
     * @param array                  $input
     */
    public function update(Wish $wish, array $input)
    {
        $input['updated_by'] = access()->user()->id;

        // Uploading Image
        if (array_key_exists('featured_image', $input)) {
            $this->deleteOldFile($wish);
            $input = $this->uploadImage($input);
        }

        DB::transaction(function () use ($wish, $input) {
            if ($wish->update($input)) {

                event(new WishUpdated($wish));

                return true;
            }

            throw new GeneralException(
                trans('exceptions.backend.wishes.update_error')
            );
        });
    }



    /**
     * @param \App\Models\Wishes\Wish $wish
     *
     * @throws GeneralException
     *
     * @return bool
     */
    public function delete(Wish $wish)
    {
        DB::transaction(function () use ($wish) {
            if ($wish->delete()) {
                event(new WishDeleted($wish));

                return true;
            }

            throw new GeneralException(trans('exceptions.backend.wishes.delete_error'));
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
        $avatar = $input['featured_image'];

        if (isset($input['featured_image']) && !empty($input['featured_image'])) {
            $fileName = time().$avatar->getClientOriginalName();

            $this->storage->put($this->upload_path.$fileName, file_get_contents($avatar->getRealPath()), 'public');

            $input = array_merge($input, ['featured_image' => $fileName]);

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
        $fileName = $model->featured_image;

        return $this->storage->delete($this->upload_path.$fileName);
    }


    public function getGroup(){

        $distribution = $this->getDistribution();

        if($distribution === $this::ROUND_ROBIN){
            return $this->getLowestWishesGroup(access()->user()->whitelabels[0]->id);
        }else if($distribution === $this::REGIONAL){
            return $this->getLowestWishesGroup(access()->user()->whitelabels[0]->id);
        }
    }

    public function getDistribution(){
        return access()->user()->whitelabels[0]->distribution->name;
    }
}