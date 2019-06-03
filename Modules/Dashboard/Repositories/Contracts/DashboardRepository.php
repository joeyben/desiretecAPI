<?php

namespace Modules\Dashboard\Repositories\Contracts;

interface DashboardRepository
{
    public function totalEventsMonth(string $gaViewId, array $optParams);
    public function totalEventsDay(string $gaViewId, array $optParams);
    public function uniqueEventsMonth(string $gaViewId, array $optParams);
}
