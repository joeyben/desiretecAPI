<?php

use App\Helpers\uuid;
use App\Models\Notification\Notification;
use App\Models\Settings\Setting;
use App\Services\Flag\Src\Flag;
use Carbon\Carbon as Carbon;
use Illuminate\Support\Facades\Log;
use Modules\Languages\Entities\Language;

/**
 * Henerate UUID.
 *
 * @return uuid
 */
function generateUuid()
{
    return uuid::uuid4();
}

if (!function_exists('homeRoute')) {
    /**
     * Return the route to the "home" page depending on authentication/authorization status.
     *
     * @return string
     */
    function homeRoute()
    {
        if (access()->allow('view-backend')) {
            return 'admin.dashboard';
        } elseif (auth()->check()) {
            return 'frontend.index';
        }

        return 'frontend.index';
    }
}

/*
 * Global helpers file with misc functions.
 */
if (!function_exists('app_name')) {
    /**
     * Helper to grab the application name.
     *
     * @return mixed
     */
    function app_name()
    {
        return config('app.name');
    }
}

if (!function_exists('access')) {
    /**
     * Access (lol) the Access:: facade as a simple function.
     */
    function access()
    {
        return app('access');
    }
}

if (!function_exists('history')) {
    /**
     * Access the history facade anywhere.
     */
    function history()
    {
        return app('history');
    }
}

if (!function_exists('gravatar')) {
    /**
     * Access the gravatar helper.
     */
    function gravatar()
    {
        return app('gravatar');
    }
}

if (!function_exists('includeRouteFiles')) {
    /**
     * Loops through a folder and requires all PHP files
     * Searches sub-directories as well.
     *
     * @param $folder
     */
    function includeRouteFiles($folder)
    {
        $directory = $folder;
        $handle = opendir($directory);
        $directory_list = [$directory];

        while (false !== ($filename = readdir($handle))) {
            if ('.' !== $filename && '..' !== $filename && is_dir($directory . $filename)) {
                array_push($directory_list, $directory . $filename . '/');
            }
        }

        foreach ($directory_list as $directory) {
            foreach (glob($directory . '*.php') as $filename) {
                require $filename;
            }
        }
    }
}

if (!function_exists('getRtlCss')) {
    /**
     * The path being passed is generated by Laravel Mix manifest file
     * The webpack plugin takes the css filenames and appends rtl before the .css extension
     * So we take the original and place that in and send back the path.
     *
     * @param $path
     *
     * @return string
     */
    function getRtlCss($path)
    {
        $path = explode('/', $path);
        $filename = end($path);
        array_pop($path);
        $filename = rtrim($filename, '.css');

        return implode('/', $path) . '/' . $filename . '.rtl.css';
    }
}

if (!function_exists('settings')) {
    /**
     * Access the settings helper.
     */
    function settings()
    {
        // Settings Details
        $settings = Setting::latest()->first();
        if (!empty($settings)) {
            return $settings;
        }
    }
}

if (!function_exists('createNotification')) {
    /**
     * create new notification.
     *
     * @param          $message message you want to show in notification
     * @param          $userId  To Whom You Want To send Notification
     * @param int|null $fromId
     *
     * @return object
     */
    function createNotification($message, $userId, int $fromId = null)
    {
        $notification = new Notification();

        return $notification->insert([
            'message'    => $message,
            'user_id'    => $userId,
            'from_id'    => $fromId,
            'type'       => 1,
            'created_at' => Carbon::now(),
        ]);
    }
}

if (!function_exists('escapeSlashes')) {
    /**
     * Access the escapeSlashes helper.
     */
    function escapeSlashes($path)
    {
        $path = str_replace('\\', DIRECTORY_SEPARATOR, $path);
        $path = str_replace('//', DIRECTORY_SEPARATOR, $path);
        $path = trim($path, DIRECTORY_SEPARATOR);

        return $path;
    }
}

if (!function_exists('getMenuItems')) {
    /**
     * Converts items (json string) to array and return array.
     */
    function getMenuItems($type = 'backend', $id = null)
    {
        $menu = new \App\Models\Menu\Menu();
        $menu = $menu->where('type', $type);
        if (!empty($id)) {
            $menu = $menu->where('id', $id);
        }
        $menu = $menu->first();
        if (!empty($menu) && !empty($menu->items)) {
            return json_decode($menu->items);
        }

        return [];
    }
}

if (!function_exists('getRouteUrl')) {
    /**
     * Converts querystring params to array and use it as route params and returns URL.
     */
    function getRouteUrl($url, $url_type = 'route', $separator = '?')
    {
        $routeUrl = '';
        if (!empty($url)) {
            if ('route' === $url_type) {
                if (false !== mb_strpos($url, $separator)) {
                    $urlArray = explode($separator, $url);
                    $url = $urlArray[0];
                    parse_str($urlArray[1], $params);
                    $routeUrl = route($url, $params);
                } else {
                    $routeUrl = route($url);
                }
            } else {
                $routeUrl = $url;
            }
        }

        return $routeUrl;
    }
}

if (!function_exists('renderMenuItems')) {
    /**
     * render sidebar menu items after permission check.
     */
    function renderMenuItems($items, $viewName = 'backend.includes.partials.sidebar-item')
    {
        foreach ($items as $item) {
            // if(!empty($item->url) && !Route::has($item->url)) {
            //     return;
            // }
            if (!empty($item->view_permission_id)) {
                if (access()->allow($item->view_permission_id)) {
                    echo view($viewName, compact('item'));
                }
            } else {
                echo view($viewName, compact('item'));
            }
        }
    }
}

if (!function_exists('isActiveMenuItem')) {
    /**
     * checks if current URL is of current menu/sub-menu.
     */
    function isActiveMenuItem($item, $separator = '?')
    {
        $item->clean_url = $item->url;
        if (false !== mb_strpos($item->url, $separator)) {
            $item->clean_url = explode($separator, $item->url, -1);
        }
        if (Active::checkRoutePattern($item->clean_url)) {
            return true;
        }
        if (!empty($item->children)) {
            foreach ($item->children as $child) {
                $child->clean_url = $child->url;
                if (false !== mb_strpos($child->url, $separator)) {
                    $child->clean_url = explode($separator, $child->url, -1);
                }
                if (Active::checkRoutePattern($child->clean_url)) {
                    return true;
                }
            }
        }

        return false;
    }
}

if (!function_exists('checkDatabaseConnection')) {
    /**
     * @return bool
     */
    function checkDatabaseConnection()
    {
        try {
            DB::connection()->reconnect();

            return true;
        } catch (Exception $ex) {
            return false;
        }
    }
}

if (!function_exists('transformTravelers')) {
    /**
     * manipulate adults string.
     *
     * @param string $travelers
     * @param string $type
     *
     * @return string
     */
    function transformTravelers($travelers, $type)
    {
        return trans_choice('labels.frontend.wishes.table.' . $type, $travelers, ['count' => $travelers]);
    }
}

if (!function_exists('transformDuration')) {
    /**
     * manipulate duration string.
     *
     * @param string $duration
     *
     * @return string
     */
    function transformDuration($duration)
    {
        switch ($duration) {
            case '7':
                return trans_choice('labels.frontend.wishes.week', 1, ['value' => 1]);

                break;

            case '14':
                return trans_choice('labels.frontend.wishes.week', 2, ['value' => 2]);
                break;

            case '21':
                return trans_choice('labels.frontend.wishes.week', 3, ['value' => 3]);
                break;

            case '28':
                return trans_choice('labels.frontend.wishes.week', 4, ['value' => 4]);
                break;

            case null:
                return 'beliebig';
                break;

            default:
                return trans_choice('labels.frontend.wishes.night', (int) $duration, ['value' => (int) $duration]);
                break;
        }
    }
}

if (!function_exists('isWhiteLabel')) {
    /**
     * Set current whitelabel Id.
     *
     * @return bool
     */
    function isWhiteLabel()
    {
        //$url = str_replace(['http://', 'https://'], ['',''], url('/'));
        //$id = \App\Models\Whitelabels\Whitelabel::Where('domain', 'like' ,'%'.$url.'%')->value('id');
        $id = getCurrentWhiteLabelField('id');

        return null !== $id;
    }
}

if (!function_exists('setCurrentWhiteLabelId')) {
    /**
     * Set current whitelabel Id.
     *
     * @param int $id
     */
    function setCurrentWhiteLabelId($id)
    {
        config(['app.current_whitelabel' => $id]);
    }
}

if (!function_exists('getCurrentWhiteLabelId')) {
    /**
     * return current whitelabel Id.
     *
     * @return int
     */
    function getCurrentWhiteLabelId()
    {
        //$url = str_replace(['http://', 'https://'], ['',''], url('/'));
        //$id = \App\Models\Whitelabels\Whitelabel::Where('domain', 'like' ,'%'.$url.'%')->value('id');
        return getCurrentWhiteLabelField('id');
        //return $id;
    }
}

if (!function_exists('getCurrentWhiteLabelName')) {
    /**
     * return current whitelabel Name.
     *
     * @return string
     */
    function getCurrentWhiteLabelName()
    {
        //$url = str_replace('http://', '', url('/'));
        //$name = \App\Models\Whitelabels\Whitelabel::Where('domain', $url)->value('name');
        $name = getCurrentWhiteLabelField('name');

        return mb_strtolower($name);
    }
}

if (!function_exists('getCurrentWhiteLabelColor')) {
    /**
     * return current whitelabel Color.
     *
     * @return string
     */
    function getCurrentWhiteLabelColor()
    {
        if (!isWhiteLabel()) {
            $defaultColor = '#f96500';

            return $defaultColor;
        }

        $color = getCurrentWhiteLabelField('color');

        return $color;
    }
}

if (!function_exists('getCurrentWhiteLabelEmail')) {
    /**
     * return current whitelabel Email.
     *
     * @return string
     */
    function getCurrentWhiteLabelEmail()
    {
        if (!isWhiteLabel()) {
            return 'noreply@desiretec.com';
        }

        $email = getCurrentWhiteLabelField('email');

        return $email;
    }
}

if (!function_exists('getCurrentWhiteLabelField')) {
    /**
     * return current whitelabel Field.
     *
     * @param string $field
     *
     * @return int
     */
    function getCurrentWhiteLabelField($field)
    {
        $url = str_replace(['http://', 'https://'], ['', ''], url('/'));
        $url = explode(':', $url)[0]; // cut the port
        //$url = str_replace('http://', '', url('/'));
        //$url = str_replace('https://', '', $url);

        return \App\Models\Whitelabels\Whitelabel::Where('domain', '=', 'https://' . $url)
            ->orWhere('domain', '=', 'http://' . $url)->value($field);
    }
}

if (!function_exists('getWhiteLabelLogo')) {
    /**
     * return current whitelabel logo url.
     *
     * @param string $type
     *
     * @return string
     */
    function getWhiteLabelLogoUrl($type = 'logo')
    {
        $attachment = \Modules\Attachments\Entities\Attachment::select([
            config('module.attachments.table') . '.basename',
            config('module.attachments.table') . '.type',
        ])
            ->where('attachable_id', getCurrentWhiteLabelId())
            ->where('type', 'whitelabels/' . $type)
            ->first();

        return null !== $attachment ? $attachment->toArray()['url'] : asset('img/logo_big.png');
    }
}

if (!function_exists('setTranslationLoaderModel')) {
    /**
     * Set translation-loader model.
     *
     * @param ClassDeclaration model
     */
    function setTranslationLoaderModel($model)
    {
        config(['translation-loader.model', $model]);
    }
}

if (!function_exists('getLanguageLinesTable')) {
    /**
     * return language lines table name.
     *
     * @return string
     */
    function getLanguageLinesTable()
    {
        if (isWhiteLabel()) {
            // $url = str_replace('http://', '', url('/'));
            // $whitelabelName = \App\Models\Whitelabels\Whitelabel::Where('domain', $url)->value('name');
            $whitelabelName = getCurrentWhiteLabelField('name');

            return \Config::get(mb_strtolower($whitelabelName) . '.language_lines_table');
        }

        return 'language_lines';
    }
}

if (!function_exists('getLanguageLinesCacheKey')) {
    /**
     * return language lines cache key.
     *
     * @return string
     */
    function getLanguageLinesCacheKey()
    {
        if (isWhiteLabel()) {
            //$url = str_replace('http://', '', url('/'));
            //$whitelabelName = \App\Models\Whitelabels\Whitelabel::Where('domain', 'like' ,'%'.$url.'%')->value('name');
            $whitelabelName = getCurrentWhiteLabelField('name');

            return $whitelabelName;
        }

        return 'admin';
    }
}

if (!function_exists('setWhitelabelLocale')) {
    /**
     * Set locale.
     *
     * @param string $locale
     */
    function setWhitelabelLocale($locale)
    {
        config(['app.locale' => $locale]);
    }
}

if (!function_exists('category_name_by_value')) {
    /**
     * Set locale.
     *
     * @param string $value
     *
     * @return string
     */
    function category_name_by_value(string $value)
    {
        return \BrianFaust\Categories\Models\Category::where('value', $value)->first()->name;
    }
}

if (!function_exists('getWhitelabelLocales')) {
    /**
     * return language lines table name.
     *
     * @return string
     */
    function getWhitelabelLocales()
    {
        if (isWhiteLabel()) {
            $whitelabelId = getCurrentWhiteLabelId();

            return Language::whereHas('whitelabels', function ($q) use ($whitelabelId) {
                $q->where('whitelabels.id', $whitelabelId);
            })->get();
        }

        return null;
    }
}

if (!function_exists('footers_by_whitelabel')) {
    /**
     * return language lines table name.
     *
     * @return string
     */
    function footers_by_whitelabel()
    {
        //$url = str_replace('http://', '', url('/'));
        //$id = \App\Models\Whitelabels\Whitelabel::Where('domain', $url)->value('id');
        $id = getCurrentWhiteLabelField('id');
        if (null !== $id) {
            $footers = \Modules\Footers\Entities\Footer::where('whitelabel_id', $id)->orderBy('position', 'ASC')->get();

            return $footers;
        }

        return [];
    }
}

if (!function_exists('getWhitelabelFooterUrl')) {
    /**
     * return url(blade-format = with dot as seperator) to the whitelabel-footer.
     *
     * @return string
     */
    function getWhitelabelFooterUrl()
    {
        $name = getCurrentWhiteLabelField('name');
        $fullFooterPath = resource_path('views/_parts/footer/' . mb_strtolower($name) . '.blade.php');
        $footerUrl = '_parts.footer.';

        if (null === $name or !file_exists($fullFooterPath)) {
            return $footerUrl . 'default';
        }

        return $footerUrl . mb_strtolower($name);
    }
}

if (!function_exists('getApiByWhitelabel')) {
    /**
     * return url(blade-format = with dot as seperator) to the whitelabel-footer.
     *
     * @return string
     */
    function getApiByWhitelabel()
    {
        $name = getCurrentWhiteLabelField('name');
    }
}

if (!function_exists('getWhitelabelAutooffers')) {
    /**
     * return url(blade-format = with dot as seperator) to the whitelabel-footer.
     *
     * @return string
     */
    function getWhitelabelAutooffers()
    {
        return \App\Models\WhitelabelAutooffer::where('whitelabel_id', getCurrentWhiteLabelId())->first();
    }
}

if (!function_exists('getKeywordText')) {
    /**
     * return language lines table name.
     *
     * @return string
     */
    function getKeywordText($value)
    {
        $keywords = \App\Models\KeywordList::where('code', $value)->first();

        return $keywords ? $keywords->name : '';
    }
}

if (!function_exists('getRegionCode')) {
    /**
     * return language lines table name.
     *
     * @return string
     */
    function getRegionCode($value, $type)
    {
        $regions = explode(',', $value);

        $codes = [];
        foreach ($regions as $region){
            array_push($codes, str_replace('region.', '', \App\Models\Regions::where('regionName', 'like', '%' . $region . '%')->where('type', $type)->first()->regionCode));
        }
        return $codes;
    }
}

if (!function_exists('getTTRegionCode')) {
    /**
     * return language lines table name.
     *
     * @return string
     */
    function getTTRegionCode($value)
    {
        $land = \App\Models\TTRegions::where('land', '=', $value)->pluck('topRegion')->all();
        $results = array_unique($land, SORT_REGULAR);

        if (empty($results)) {
            $region = \App\Models\TTRegions::where('topRegionName', '=', $value)->pluck('topRegion')->all();
            $results = array_unique($region, SORT_REGULAR);
        }

        return $results;
    }
}

if (!function_exists('getTTRegions')) {
    /**
     * return language lines table name.
     *
     * @return string
     */
    function getTTRegions($value)
    {
        return \App\Models\TTRegions::where('ort', 'like', '%' . $value . '%')->select('topRegionName')->first()->topRegionName;
    }
}

if (!function_exists('getTTRegionCodeFromOrt')) {
    /**
     * return language lines table name.
     *
     * @return string
     */
    function getTTRegionCodeFromOrt($value)
    {
        return \App\Models\TTRegions::where('ort', 'like', '%' . $value . '%')->select('topRegion')->first()['topRegion'];
    }
}

if (!function_exists('getTTAirports')) {
    /**
     * return Airport code.
     *
     * @return string
     */
    function getTTAirports($value)
    {
        return \App\Models\TTAirports::where('name', 'like', '%' . $value . '%')->select('code')->first()->code;
    }
}

if (!function_exists('getCateringFromCode')) {
    /**
     * return language lines table name.
     *
     * @return string
     */
    function getCateringFromCode($code)
    {
        $category = '';
        switch ($code) {
            case '1':
                $category = 'Ohne Verpflegung';
                break;
            case '2':
                $category = 'Frühstück';
                break;
            case '3':
                $category = 'Halbpension';
                break;
            case '4':
                $category = 'Vollpension';
                break;
            case '5':
                $category = 'All Inclusive';
                break;
            default:
                $category = 'Ohne Verpflegung';
        }

        return $category;
    }
}

if (!function_exists('json_response')) {
    /**
     * return response JSON with added status.
     *
     * @param array $result
     *
     * @return RESPONSE JSON
     */
    function json_response($result)
    {
        $result['success'] = true;
        $result['status'] = Flag::STATUS_CODE_SUCCESS;

        return response()->json($result, $result['status'], [], JSON_NUMERIC_CHECK);
    }
}

if (!function_exists('json_response_error')) {
    /**
     * return response Error JSON with added status.
     *
     * @param Exception $error
     *
     * @return RESPONSE JSON
     */
    function json_response_error($error)
    {
        $result['success'] = false;
        $result['status'] = $error->getStatusCode();
        $result['message'] = $error->getMessage();

        Log::error($error);

        return response()->json($result, $result['status'], [], JSON_NUMERIC_CHECK);
    }
}

if (!function_exists('live_preview_url')) {
    function live_preview_url()
    {
        $link = 'javascript:;';
        $whitelabel = \Illuminate\Support\Facades\Auth::guard('web')->user()->whitelabels()->first();

        if (null !== $whitelabel) {
            $link = $whitelabel->domain;
        }

        return $link;
    }
}

/**
 * Returns the Domain for the current WL
 */
if (!function_exists('get_current_whitelabel_url')) {
    function get_current_whitelabel_url()
    {
        return getCurrentWhiteLabelField('domain');
    }
}