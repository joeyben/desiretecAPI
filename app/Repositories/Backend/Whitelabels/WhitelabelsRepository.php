<?php

namespace App\Repositories\Backend\Whitelabels;

use App\Events\Backend\Whitelabels\WhitelabelCreated;
use App\Events\Backend\Whitelabels\WhitelabelDeleted;
use App\Events\Backend\Whitelabels\WhitelabelUpdated;
use App\Exceptions\GeneralException;
use App\Models\Whitelabels\Whitelabel;
use App\Repositories\BaseRepository;
use DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;

/**
 * Class WhitelabelsRepository.
 */
class WhitelabelsRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Whitelabel::class;

    protected $upload_path;

    /**
     * Storage Class Object.
     *
     * @var \Illuminate\Support\Facades\Storage
     */
    protected $storage;

    public function __construct()
    {
        $this->upload_path = 'img' . \DIRECTORY_SEPARATOR . 'whitelabel' . \DIRECTORY_SEPARATOR;
        $this->storage = Storage::disk('s3');
    }

    /**
     * @return mixed
     */
    public function getForDataTable()
    {
        $dataTableQuery = $this->query()
            ->leftjoin(config('access.users_table'), config('access.users_table') . '.id', '=', config('module.whitelabels.table') . '.created_by')
            ->select([
                config('module.whitelabels.table') . '.id',
                config('module.whitelabels.table') . '.name',
                config('module.whitelabels.table') . '.display_name',
                config('module.whitelabels.table') . '.status',
                config('module.whitelabels.table') . '.distribution_id',
                config('module.whitelabels.table') . '.ga_view_id',
                config('module.whitelabels.table') . '.created_by',
                config('module.whitelabels.table') . '.created_at',
                config('module.whitelabels.table') . '.color',
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

            if ($whitelabel = Whitelabel::create($input)) {
                event(new WhitelabelCreated($whitelabel));
                $command = sprintf(
                    'php artisan module:make %s',
                    ucfirst($input['name'])
                );

                $p = new Process($command);
                $p->setWorkingDirectory(base_path());
                $p->run();

                return true;
            }

            throw new GeneralException(trans('exceptions.backend.whitelabels.create_error'));
        });
    }

    /**
     * Update Whitelabel.
     *
     * @param \App\Models\Whitelabels\Whitelabel $whitelabel
     * @param array                              $input
     */
    public function update(Whitelabel $whitelabel, array $input)
    {
        $input['updated_by'] = access()->user()->id;

        // Uploading Image
        if (\array_key_exists('bg_image', $input)) {
            $this->deleteOldFile($whitelabel);
            $input = $this->uploadImage($input);
        }

        DB::transaction(function () use ($whitelabel, $input) {
            if ($whitelabel->update($input)) {
                event(new WhitelabelUpdated($whitelabel));

                return true;
            }

            throw new GeneralException(
                trans('exceptions.backend.whitelabels.update_error')
            );
        });
    }

    /**
     * @param \App\Models\Whitelabels\Whitelabel $whitelabel
     *
     * @throws GeneralException
     *
     * @return bool
     */
    public function delete(Whitelabel $whitelabel)
    {
        DB::transaction(function () use ($whitelabel) {
            if ($whitelabel->delete()) {
                event(new WhitelabelDeleted($whitelabel));

                return true;
            }

            throw new GeneralException(trans('exceptions.backend.whitelabels.delete_error'));
        });
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function getByName($name)
    {
        return $this->query()

            ->select([
                config('module.whitelabels.table') . '.id',
                config('module.whitelabels.table') . '.name',
                config('module.whitelabels.table') . '.display_name',
                config('module.whitelabels.table') . '.status',
                config('module.whitelabels.table') . '.bg_image',
                config('module.whitelabels.table') . '.color',
            ])
            ->where('name', $name)
            ->first()->toArray();
    }

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function getById($id)
    {
        return $this->query()

            ->select([
                config('module.whitelabels.table') . '.id',
                config('module.whitelabels.table') . '.name',
                config('module.whitelabels.table') . '.display_name',
                config('module.whitelabels.table') . '.status',
                config('module.whitelabels.table') . '.bg_image',
                config('module.whitelabels.table') . '.color',
            ])
            ->where('id', $id)
            ->first()->toArray();
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
        $avatar = $input['bg_image'];

        if (isset($input['bg_image']) && !empty($input['bg_image'])) {
            $fileName = time() . $avatar->getClientOriginalName();

            $this->storage->put($this->upload_path . $fileName, file_get_contents($avatar->getRealPath()), 'public');

            $input = array_merge($input, ['bg_image' => $fileName]);

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
        $fileName = $model->bg_image;

        return $this->storage->delete($this->upload_path . $fileName);
    }
}
