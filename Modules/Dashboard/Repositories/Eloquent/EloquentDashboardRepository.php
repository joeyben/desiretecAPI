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

    public function uniqueEventsDay(string $gaViewId, array $optParams, string $startDate, string $endDate)
    {
        return \Analytics::getAnalyticsService()->data_ga->get(
            'ga:'.$gaViewId,
            ($startDate === '') ? '30daysAgo' : $startDate ,
            ($endDate === '') ?'yesterday' : $endDate,
            'ga:uniqueEvents',
            $optParams
        )->rows;
    }

    public function uniqueEventsMonth(string $gaViewId, array $optParams, string $startDate, string $endDate)
    {
        return \Analytics::getAnalyticsService()->data_ga->get(
            'ga:'.$gaViewId,
            ($startDate === '') ? '365daysAgo' : $startDate,
            ($endDate === '') ? 'yesterday' : $endDate,
            'ga:uniqueEvents',
            $optParams
        )->rows;
    }
}
