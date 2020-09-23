<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Bestfewo;
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
        $destinations = [];
        PWRegions::select('name', 'country_name')
            ->where('name', 'like', $query . '%')
            ->orWhere('country_name', 'like', $query . '%')
            ->groupBy('name')
            ->chunk(200, function ($regions) use (&$destinations) {
                foreach ($regions as $region) {
                    $destinations[] = $region->name != "-" ? $region->country_name .' - '. $region->name
                                        : $region->country_name;
                }
            });

        return $destinations;
    }

    public function getAllBFDestinations(Request $request)
    {

        $query = $request->get('query');
        $destinations = [];
        $regionsArr = [];
        $countries = [];
        Bestfewo::select('city','country')
            ->where('city', 'like', $query . '%')
            ->groupBy('city')
            ->chunk(200, function ($regions) use (&$destinations) {
                foreach ($regions as $region) {
                    $destinations[] = $region->country .' - '. $region->city;
                }
            });

        Bestfewo::select('region','country')
            ->where('region', 'like', $query . '%')
            ->groupBy('region')
            ->chunk(200, function ($regions) use (&$regionsArr) {
                foreach ($regions as $region) {
                    $regionsArr[] = $region->country .' - '. $region->region.'(Region)';
                }
            });

        Bestfewo::select('country')
            ->where('country', 'like', $query . '%')
            ->groupBy('country')
            ->chunk(200, function ($regions) use (&$countries) {
                foreach ($regions as $region) {
                    $countries[] = $region->country .'(Land)';
                }
            });

        $result = array_merge($destinations, $regionsArr, $countries);
        return sort($result);
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
