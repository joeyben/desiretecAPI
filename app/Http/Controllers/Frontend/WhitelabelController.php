<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Settings\Setting;
use App\Repositories\Frontend\Pages\PagesRepository;

/**
 * Class WhitelabelController.
 */
class WhitelabelController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $settingData = Setting::first();
        $google_analytics = $settingData->google_analytics;
        $whitelabel_name = 'tui';
        $bg_image = 'https://malediven.de/wp-content/uploads/2016/12/malediven-slider-startseite-conrad-1654x930.jpg';
        return view('whitelabel.index', compact('google_analytics', $google_analytics, 'whitelabel_name', 'bg_image'));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function macros()
    {
        return view('whitelabel.macros');
    }

    /**
     * show page by $page_slug.
     */
    public function showPage($slug, PagesRepository $pages)
    {
        $result = $pages->findBySlug($slug);

        return view('whitelabel.pages.index')
            ->withpage($result);
    }
}
