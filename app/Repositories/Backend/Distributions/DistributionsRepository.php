<?php

namespace App\Repositories\Backend\Distributions;

use App\Events\Backend\Distributions\DistributionCreated;
use App\Events\Backend\Distributions\DistributionDeleted;
use App\Events\Backend\Distributions\DistributionUpdated;
use App\Exceptions\GeneralException;
use App\Models\Distributions\Distribution;
use App\Repositories\BaseRepository;
use DB;

/**
 * Class DistributionsRepository.
 */
class DistributionsRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Distribution::class;

    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getForDataTable()
    {
        return $this->query()
            ->leftjoin(config('access.users_table'), config('access.users_table').'.id', '=', config('module.distributions.table').'.created_by')
            ->select([
                config('module.distributions.table').'.name',
                config('module.distributions.table').'.display_name',
                config('module.distributions.table').'.description',
                config('module.distributions.table').'.created_by',
                config('module.distributions.table').'.created_at',
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

            if ($distribution = Distribution::create($input)) {

                event(new DistributionCreated($distribution));

                return true;
            }

            throw new GeneralException(trans('exceptions.backend.distributions.create_error'));
        });
    }

    /**
     * Update Distribution.
     *
     * @param \App\Models\Distributions\Distribution $distribution
     * @param array                  $input
     */
    public function update(Distribution $distribution, array $input)
    {
        $input['updated_by'] = access()->user()->id;
        

        DB::transaction(function () use ($distribution, $input) {
            if ($distribution->update($input)) {

                event(new DistributionUpdated($distribution));

                return true;
            }

            throw new GeneralException(
                trans('exceptions.backend.distributions.update_error')
            );
        });
    }



    /**
     * @param \App\Models\Distributions\Distribution $distribution
     *
     * @throws GeneralException
     *
     * @return bool
     */
    public function delete(Distribution $distribution)
    {
        DB::transaction(function () use ($distribution) {
            if ($distribution->delete()) {
                event(new DistributionDeleted($distribution));

                return true;
            }

            throw new GeneralException(trans('exceptions.backend.distributions.delete_error'));
        });
    }
    
}
