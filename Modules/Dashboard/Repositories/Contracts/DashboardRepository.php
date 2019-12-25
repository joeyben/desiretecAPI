<?php

namespace Modules\Dashboard\Repositories\Contracts;

use Illuminate\Http\Request;

interface DashboardRepository
{
    public function uniqueEventsDay(string $gaViewId, array $optParams, string $startDate, string $endDate);

    public function uniqueEventsMonth(string $gaViewId, array $optParams, string $startDate, string $endDate);

    public function calculateBrowserData(array $result, array $browsers, int $sum);

    public function calculateResponseData($result, $data, $stack);

    public function loadClickRate($whitelabel);

    public function loadOpenRate($whitelabel);

    public function loadClickRateauto($whitelabel);

    public function loadOpenRateauto($whitelabel);

    public function getFilterCategory(string $category);

    public function getFilterCategoryPosition(string $category);

    public function setFilterCategory(Request $request);

    public function setFilterCategoryPosition($result, string $position, int $id1, int $id2);

    public function setFilterCategoryPositionById($dashboard);
}
