<?php

/**
 * Created by PhpStorm.
 * User: goldoni
 * Date: 12.12.18
 * Time: 13:29.
 */

namespace App\Services\Flag\Src;

use App\Services\Flag\Interfaces\FlagInterface;

/**
 * Class Flag.
 */
class Flag implements FlagInterface
{
    // OK. The standard success code and default option.
    const STATUS_CODE_SUCCESS = 200;
    // Unauthorized. The user needs to be authenticated.
    const STATUS_CODE_UNAUTHORIZED = 401;
    // Forbidden. The user is authenticated, but does not have the permissions to perform an action.
    const STATUS_CODE_FORBIDDEN = 403;
    // Not found. This will be returned automatically by Laravel when the resource is not found.
    const STATUS_CODE_NOT_FOUND = 404;
    /*
     * Internal server error.
     * Ideally you're not going to be explicitly returning this,
     * but if something unexpected breaks, this is what your user is going to receive.
     */
    const STATUS_CODE_ERROR = 500;

    /*
     * Service unavailable.
     * Pretty self explanatory, but also another code that is not going to be returned explicitly by the application.
     */
    const STATUS_CODE_SERVICE_UNAVAILABLE = 503;

    const ADMINISTRATOR_ROLE = 'Administrator';

    const EXECUTIVE_ROLE = 'Executive';

    const SELLER_ROLE = 'Seller';

    const USER_ROLE = 'User';

    const UPLOADS = 'uploads';

    const PACKAGE = 1;

    const FLIGHT = 2;

    const CRUISE = 3;

    const COLOR = '#f96500';

    const HTTP = 'http://';

    const HTTPS = 'https://';

    const LIGHT = 0;

    const BASIC = 1;

    const PREMIUM = 2;

    const MIX = 3;

    const MAX_STEP = 10;

    public static function step()
    {
        return [
            1 => [
                'name' => 'Step 1: White Label',
                'route' => 'provider.whitelabels',
                'url' => route('provider.whitelabels')
            ],
            2 => [
                'name' => 'Step 2: Layer Management',
                'route' => 'admin.whitelabels.layers',
                'url' => route('admin.whitelabels.layers')
            ],
            3 => [
                'name' => 'Step 3: E-Mail Signature',
                'route' => 'provider.email.signature',
                'url' => route('provider.email.signature', app()->getLocale())
            ],
            4 => [
                'name' => 'Step 4: Footers',
                'route' => 'admin.footers',
                'url' => route('admin.footers')
            ],
            5 => [
                'name' => 'Step 5: Teilnahmebedingungen',
                'route' => 'provider.whitelabels.tnb',
                'url' => route('provider.footer.tnb', app()->getLocale())
            ],
            6 => [
                'name' => 'Step 6: Anbieter Management',
                'route' => 'admin.sellers',
                'url' => route('admin.sellers')
            ],
            7 => [
                'name' => 'Step 7: Gruppen Management',
                'route' => 'admin.groups',
                'url' => route('admin.groups')
            ],
            8 => [
                'name' => 'Step 8: (if BASIC or PREMIUM)',
                'route' => 'admin.rules',
                'url' => route('admin.rules')
            ],
            9 => [
                'name' => 'Step 9 (if BASIC or PREMIUM)',
                'route' => 'autooffer.setting',
                'url' => route('autooffer.setting')
            ],
            10 => [
                'name' => 'Step 10: Download JS Snippet',
                'route' => '#',
                'url' => '#'
            ]
        ];
    }
}
