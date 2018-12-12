<?php

/**
 * Created by PhpStorm.
 * User: emere
 * Date: 29/03/2018
 * Time: 06:58.
 */

namespace App\Services\Flag\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class FlagFacade.
 */
class Flag extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'App\Services\Flag\Interfaces\FlagInterface';
    }
}
