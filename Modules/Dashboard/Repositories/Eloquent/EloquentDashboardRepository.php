<?php

/**
 * Created by PhpStorm.
 * User: goldoni
 * Date: 24.09.18
 * Time: 21:18.
 */

namespace Modules\Dashboard\Repositories\Eloquent;

use App\Repositories\RepositoryAbstract;
use Modules\Dashboard\Entities\Dashboard;
use Modules\Dashboard\Repositories\Contracts\DashboardRepository;

/**
 * Class EloquentDashboardRepository.
 */
class EloquentDashboardRepository extends RepositoryAbstract implements DashboardRepository
{
    public function model()
    {
        return Dashboard::class;
    }

    public function totalEvents(string $gaViewId, array $optParams)
    {
        return \Analytics::getAnalyticsService()->data_ga->get(
            'ga:'.$gaViewId,
            '365daysAgo',
            'yesterday',
            'ga:totalEvents',
            $optParams
        )->rows;
    }
}
