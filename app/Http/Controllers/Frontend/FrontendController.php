<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Regions;
use App\Models\Settings\Setting;
use App\Repositories\Frontend\Pages\PagesRepository;
use Illuminate\Http\Request;
use Modules\Languages\Repositories\Contracts\LanguagesRepository;

/**
 * Class FrontendController.
 */
class FrontendController extends Controller
{
    /**
     * @var \Modules\Languages\Repositories\Contracts\LanguagesRepository
     */
    private $languages;

    const BODY_CLASS = 'landing';

    public function __construct(LanguagesRepository $languages)
    {
        $this->languages = $languages;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $settingData = Setting::first();
        $google_analytics = $settingData->google_analytics;
        $body_class = $this::BODY_CLASS;
        $languages = $this->languages->findLanguages();

        return view('frontend.index', compact('google_analytics', 'body_class', 'languages'));
    }

    /**
     * show page by $page_slug.
     */
    public function showPage($slug, PagesRepository $pages)
    {
        $result = $pages->findBySlug($slug);

        return view('frontend.pages.index')
            ->withpage($result);
    }

    /**
     * URL: /get-all-destinations
     * Returns all destinations.
     *
     * @return array
     */
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

    /**
     * URL: /get-all-airports
     * Returns all airports.
     *
     * @return array
     */
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
     * Builds the main-layer with all WLs layer
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLayer(Request $request)
    {
        return view('frontend.layers.layer', [
            'layers' => [
                [
                    'id' => 1,
                    'name' => 'cruise',
                    'active' => true,
                    'request' => $request,
                    'title' => 'cruise title',
                    'text' => 'cruise text',
                    'bgImage' => 'https://i.ytimg.com/vi/fCaNg3zVY2s/maxresdefault.jpg'
                ],
                [
                    'id' => 2,
                    'name' => 'flight',
                    'active' => false,
                    'request' => $request,
                    'title' => 'flight title',
                    'text' => 'flight text',
                    'bgImage' => 'https://tackatacka.com/portals/0/Images/Flights/flight-tickets.jpg'
                ],
                [
                    'id' => 3,
                    'name' => 'package',
                    'active' => false,
                    'request' => $request,
                    'title' => 'package title',
                    'text' => 'package text',
                    'bgImage' => ''
                ],
            ],
            'color' => '#808000',
        ]);
    }
}
