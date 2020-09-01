<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Regions;
use App\Models\PWRegions;
use App\Models\TTAirports;
use Illuminate\Http\Request;

/**
 * Class RegionsController.
 */
class RegionsController extends Controller
{
    public function getAllDestinations(Request $request)
    {
        $query = $request->get('query');
        $destinations = [];
        Regions::select('regionName')
            ->where('type', '1')
            ->where('regionName', 'like', $query . '%')
            ->groupBy('regionName')
            ->chunk(200, function ($regions) use (&$destinations) {
                foreach ($regions as $region) {
                    $destinations[] = $region->regionName;
                }
            });

        return $destinations;
    }

    public function getAllPWDestinations(Request $request)
    {

        $query = $request->get('query');
        $countries = [];
        $destinations = [];
        PWRegions::select('name', 'country_name')
            ->where('country_name', 'like', $query . '%')
            ->where('name', '-')
            ->groupBy('country_name')
            ->chunk(200, function ($regions) use (&$destinations) {
                foreach ($regions as $region) {
                    $countries[] = $region->country_name;
                }
            });

        PWRegions::select('name', 'country_name')
            ->where('name', 'like', $query . '%')
            ->where('name', '!=', '-')
            ->groupBy('name')
            ->chunk(200, function ($regions) use (&$destinations) {
                foreach ($regions as $region) {
                    $destinations[] = $region->country_name .' - '. $region->name;
                }
            });

        return array_merge($destinations, $countries);
    }


    public function getAllAirports(Request $request)
    {
        $query = $request->get('query');
        $airports = [];
        Regions::select('regionCode', 'regionName')
            ->where('type', 0)
            ->where('regionName', 'like', $query . '%')
            ->groupBy('regionName')
            ->chunk(200, function ($regions) use (&$airports) {
                foreach ($regions as $region) {
                    $airports[] = $region->regionName;
                }
            });

        return $airports;
    }
    /**
     * URL: /get-all-airports
     * Returns all airports.
     *
     * @return array
     */
    public function getAllTTAirports()
    {
        $airports = [];
        TTAirports::select('name', 'code')
            ->where('whitelabel', 87)
            ->groupBy('name')
            ->chunk(200, function ($regions) use (&$airports) {
                foreach ($regions as $region) {
                    $airports[] = $region->name;
                }
            });

        return $airports;
    }
}
