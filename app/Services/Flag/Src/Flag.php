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

    const SELLER_ROLE = 'Seller';

    const UPLOADS = 'uploads';
}
