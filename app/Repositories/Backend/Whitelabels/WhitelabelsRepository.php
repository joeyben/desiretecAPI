<?php

namespace App\Repositories\Backend\Whitelabels;

use App\Events\Backend\Whitelabels\WhitelabelCreated;
use App\Events\Backend\Whitelabels\WhitelabelDeleted;
use App\Events\Backend\Whitelabels\WhitelabelUpdated;
use App\Exceptions\GeneralException;
use App\Models\Whitelabels\Whitelabel;
use App\Repositories\BaseRepository;
use DB;

/**
 * Class WhitelabelsRepository.
 */
class WhitelabelsRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Whitelabel::class;

    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getForDataTable()
    {
        return $this->query()
            ->leftjoin(config('access.users_table'), config('access.users_table').'.id', '=', config('module.whitelabels.table').'.created_by')
            ->select([
                config('module.whitelabels.table').'.id',
                config('module.whitelabels.table').'.name',
                config('module.whitelabels.table').'.display_name',
                config('module.whitelabels.table').'.status',
                config('module.whitelabels.table').'.distribution_id',
                config('module.whitelabels.table').'.created_by',
                config('module.whitelabels.table').'.created_at',
            ]);
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
            $input['created_by'] = access()->user()->id;

            if ($whitelabel = Whitelabel::create($input)) {

                event(new WhitelabelCreated($whitelabel));

                return true;
            }

            throw new GeneralException(trans('exceptions.backend.whitelabels.create_error'));
        });
    }

    /**
     * Update Whitelabel.
     *
     * @param \App\Models\Whitelabels\Whitelabel $whitelabel
     * @param array                  $input
     */
    public function update(Whitelabel $whitelabel, array $input)
    {
        $input['updated_by'] = access()->user()->id;

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
    
}
