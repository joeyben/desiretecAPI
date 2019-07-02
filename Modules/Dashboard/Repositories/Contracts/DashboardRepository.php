<?php

namespace Modules\Dashboard\Repositories\Contracts;
use Illuminate\Http\Request;

interface DashboardRepository
{
    public function uniqueEventsDay(string $gaViewId, array $optParams, string $startDate, string $endDate);
    public function uniqueEventsMonth(string $gaViewId, array $optParams, string $startDate, string $endDate);
    public function calculateBrowserData(array $result, array $browsers, int $sum);
    public function calculateResponseData($result, $data, $stack);
    public function loadClickRate();
    public function getFilterCategory(string $category);
    public function setFilterCategory(Request $request);
}
