<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Regions;
use App\Models\Settings\Setting;
use App\Repositories\Frontend\Pages\PagesRepository;
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
     * Returns all destinations
     *
     * @return array
     */
    public function getAllDestinations(){
        $destinations = [];
        Regions::select('regionName')->where('type', 1)->chunk(200, function($regions) use(&$destinations){
           foreach ($regions as $region){
               $destinations[] = $region->regionName;
           }
        });
        return $destinations;
    }

    /**
     * URL: /get-all-airports
     * Returns all airports
     *
     * @return array
     */
    public function getAllAirports(){
        $airports = [];
        Regions::select('regionCode', 'regionName')->where('type', 0)->chunk(200, function($regions) use(&$airports){
            foreach ($regions as $region){
                $airports[] = $region->regionName . ' - '. $region->regionCode;
            }
        });
        return $airports;
    }
}
