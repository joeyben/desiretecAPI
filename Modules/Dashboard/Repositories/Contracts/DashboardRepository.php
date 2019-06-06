<?php

namespace Modules\Dashboard\Repositories\Contracts;

interface DashboardRepository
{
    public function uniqueEventsDay(string $gaViewId, array $optParams, string $startDate, string $endDate);
    public function uniqueEventsMonth(string $gaViewId, array $optParams, string $startDate, string $endDate);
}
