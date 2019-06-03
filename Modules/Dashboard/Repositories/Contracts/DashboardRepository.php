<?php

namespace Modules\Dashboard\Repositories\Contracts;

interface DashboardRepository
{
    public function totalEvents(string $gaViewId, array $optParams);
}
