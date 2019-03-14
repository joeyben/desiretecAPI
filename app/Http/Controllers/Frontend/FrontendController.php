<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
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
}
