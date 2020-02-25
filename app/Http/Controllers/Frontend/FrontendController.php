<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Regions;
use App\Models\Settings\Setting;
use App\Repositories\Criteria\Where;
use App\Repositories\Frontend\Pages\PagesRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Languages\Repositories\Contracts\LanguagesRepository;
use Modules\LanguageLines\Repositories\Contracts\LanguageLinesRepository;
use Auth;

/**
 * Class FrontendController.
 */
class FrontendController extends Controller
{
    /**
     * @var \Modules\Languages\Repositories\Contracts\LanguagesRepository
     */
    private $languages;
    /**
     * @var \Modules\LanguageLines\Repositories\Contracts\LanguageLinesRepository
     */
    private $languageline;

    const BODY_CLASS = 'landing';

    public function __construct(LanguagesRepository $languages, LanguageLinesRepository $languageline)
    {
        $this->languages = $languages;
        $this->languageline = $languageline;
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
     * Respective Domain Teilnahmebedingungen.
     *
     * @return view
     */
    public function showTnb(Request $request)
    {
        try {
            $arr = explode(".", $request->root());
            $domain = explode("//", $arr[0]);

            if (!$this->isOldWhitelabel()) {
                if(!$this->languageline->withCriteria([
                    new Where('locale', 'de'),
                    new Where('key', 'footer.tnb'),
                    new Where('group', 'layer'),
                    new Where('whitelabel_id', getWhitelabelBySlug($domain[1])->first()->id),
                ])->get()->isEmpty()){
                    $tnb = $this->languageline->withCriteria([
                        new Where('locale', 'de'),
                        new Where('key', 'footer.tnb'),
                        new Where('group', 'layer'),
                        new Where('whitelabel_id', getWhitelabelBySlug($domain[1])->first()->id),
                    ])->get()->first()->text;

                    return view('frontend.tnb.tnb', compact(['tnb']));
                } else {
                    $tnb = trans('errors.tnb.notset');
                    return view('frontend.tnb.tnb', compact(['tnb']));
                }
            } else {
                if(!DB::table("language_lines_{$domain[1]}")
                    ->select('text')
                    ->where('locale', 'de')
                    ->where('group', 'layer')
                    ->where('key', 'footer.tnb')
                    ->get()->isEmpty()){
                    $tnb = DB::table("language_lines_{$domain[1]}")
                        ->select('text')
                        ->where('locale', 'de')
                        ->where('group', 'layer')
                        ->where('key', 'footer.tnb')
                        ->get()->first()->text;

                    return view('frontend.tnb.tnb', compact(['tnb']));
                } else {
                    $tnb = trans('errors.tnb.notset');
                    return view('frontend.tnb.tnb', compact(['tnb']));
                }
            }
        } catch (\Exception $e){
            $tnb = $e->getMessage();
            return view('frontend.tnb.tnb', compact(['tnb']));
        }
    }
}
