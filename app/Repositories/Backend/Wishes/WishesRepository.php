<?php

namespace App\Repositories\Backend\Wishes;

use App\Events\Backend\Wishes\WishCreated;
use App\Events\Backend\Wishes\WishDeleted;
use App\Events\Backend\Wishes\WishUpdated;
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

    protected $upload_path;

    /**
     * Storage Class Object.
     *
     * @var \Illuminate\Support\Facades\Storage
     */
    protected $storage;

    public function __construct()
    {
        $this->upload_path = 'img' . \DIRECTORY_SEPARATOR . 'wish' . \DIRECTORY_SEPARATOR;
        $this->storage = Storage::disk('s3');
    }

    /**
     * @return mixed
     */
    public function getForDataTable()
    {
        $dataTableQuery = $this->query()
            ->leftjoin(config('access.users_table'), config('access.users_table') . '.id', '=', config('module.wishes.table') . '.created_by')
            ->leftjoin(config('module.whitelabels.table'), config('module.whitelabels.table') . '.id', '=', config('module.wishes.table') . '.whitelabel_id')
            ->leftjoin(config('module.groups.table'), config('module.groups.table') . '.id', '=', config('module.wishes.table') . '.group_id')
            ->select([
                config('module.wishes.table') . '.id',
                config('module.wishes.table') . '.title',
                config('module.wishes.table') . '.status',
                config('module.wishes.table') . '.created_by',
                config('module.wishes.table') . '.created_at',
                config('access.users_table') . '.first_name as user_name',
                config('module.whitelabels.table') . '.id as whitelabel_id',
                config('module.whitelabels.table') . '.display_name as whitelabel_name',
                config('module.groups.table') . '.id as group_id',
                config('module.groups.table') . '.display_name as group_name',
            ]);

        $dataTableQuery->when(access()->user()->hasRole('Executive') && !access()->user()->hasRole('Administrator'), function ($q) {
            $q->whereIn(config('module.whitelabels.table') . '.id', access()->user()->whitelabels()->get()->pluck('id')->toArray());
        });

        return $dataTableQuery;
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
     * @param array                   $input
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
            $fileName = time() . $avatar->getClientOriginalName();

            $this->storage->put($this->upload_path . $fileName, file_get_contents($avatar->getRealPath()), 'public');

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

        return $this->storage->delete($this->upload_path . $fileName);
    }
}
