<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Regions;
use App\Models\TTAirports;
use App\Models\TTRegions;
use Illuminate\Http\Request;

/**
 * Class RegionsController.
 */
class RegionsController extends Controller
{
    /**
     * URL: /get-all-destinations
     * Returns all destinations.
     *
     * @return array
     */
    public function getTTRegions()
    {
        $destinations = [];
        TTRegions::select(['land'])->chunk(200, function ($regions) use (&$destinations) {
            foreach ($regions as $region) {
                if (!\in_array($region->land, $destinations, true)) {
                    $destinations[] = $region->land;
                }
            }
        });

        TTRegions::select(['topRegionName'])->chunk(200, function ($regions) use (&$destinations) {
            foreach ($regions as $region) {
                if (!\in_array($region->topRegionName, $destinations, true)) {
                    $destinations[] = $region->topRegionName;
                }
            }
        });

        return $destinations;
    }

    /**
     * URL: /get-all-destinations
     * Returns all destinations.
     *
     * @return array
     */
    public function getAllDestinations()
    {
        $destinations = [];
        Regions::select('regionName')->where('type', 1)->chunk(200, function ($regions) use (&$destinations) {
            foreach ($regions as $region) {
                $destinations[] = $region->regionName;
            }
        });

        return $destinations;
    }

    /**
     * URL: /get-all-airports
     * Returns all airports.
     *
     * @return array
     */
    public function getAllAirports()
    {
        $airports = [];
        Regions::select('regionCode', 'regionName')->where('type', 0)->chunk(200, function ($regions) use (&$airports) {
            foreach ($regions as $region) {
                $airports[] = $region->regionName . ' - ' . $region->regionCode;
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

    /**
     * URL: /get-all-airports
     * Returns all airports.
     *
     * @return array
     */
    public function getTTAirports(Request $request)
    {
        $query = $request->get('query');
        $airports = [];
        TTAirports::select('name', 'code')
            ->where('whitelabel', getCurrentWhiteLabelId())
            ->where('name', 'like', $query . '%')
            ->groupBy('name')
            ->chunk(200, function ($regions) use (&$airports) {
                foreach ($regions as $region) {
                    $airports[] = $region->name;
                }
            });

        return $airports;
    }
}
