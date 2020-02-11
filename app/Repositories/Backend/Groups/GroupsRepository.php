<?php

namespace App\Repositories\Backend\Groups;

use App\Events\Backend\Groups\GroupCreated;
use App\Events\Backend\Groups\GroupDeleted;
use App\Events\Backend\Groups\GroupUpdated;
use App\Exceptions\GeneralException;
use App\Models\Groups\Group;
use App\Repositories\BaseRepository;
use DB;
use Illuminate\Support\Facades\Storage;

/**
 * Class GroupsRepository.
 */
class GroupsRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Group::class;

    /**
     * Storage Class Object.
     *
     * @var \Illuminate\Support\Facades\Storage
     */
    protected $storage;

    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getForDataTable()
    {
        $dataTableQuery = $this->query()
            ->leftjoin(config('module.whitelabels.table'), config('module.whitelabels.table') . '.id', '=', config('module.groups.table') . '.whitelabel_id')
            ->select([
                config('module.groups.table') . '.id',
                config('module.groups.table') . '.name',
                config('module.groups.table') . '.display_name',
                config('module.groups.table') . '.description',
                config('module.groups.table') . '.status',
                config('module.groups.table') . '.created_at',
                config('module.whitelabels.table') . '.id as whitelabel_id',
                config('module.whitelabels.table') . '.display_name as whitelabel_name',
            ]);
        $dataTableQuery->when(access()->user()->hasRole('Executive') && !access()->user()->hasRole('Administrator'), function ($q) {
            $q->whereIn('whitelabel_id', access()->user()->whitelabels()->get()->pluck('id')->toArray());
        });

        return $dataTableQuery;
    }

    /**
     * @throws \App\Exceptions\GeneralException
     *
     * @return bool
     */
    public function create(array $input)
    {
        DB::transaction(function () use ($input) {
            $input['created_by'] = access()->user()->id;

            if ($group = Group::create($input)) {
                event(new GroupCreated($group));

                return true;
            }

            throw new GeneralException(trans('exceptions.backend.groups.create_error'));
        });
    }

    /**
     * Update Group.
     */
    public function update(Group $group, array $input)
    {
        $input['updated_by'] = access()->user()->id;

        DB::transaction(function () use ($group, $input) {
            if ($group->update($input)) {
                event(new GroupUpdated($group));

                return true;
            }

            throw new GeneralException(trans('exceptions.backend.groups.update_error'));
        });
    }

    /**
     * @throws GeneralException
     *
     * @return bool
     */
    public function delete(Group $group)
    {
        DB::transaction(function () use ($group) {
            if ($group->delete()) {
                event(new GroupDeleted($group));

                return true;
            }

            throw new GeneralException(trans('exceptions.backend.groups.delete_error'));
        });
    }
}
