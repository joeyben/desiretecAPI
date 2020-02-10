<?php
/**
 * Created by PhpStorm.
 * User: gencgruda
 * Date: 2019-12-23
 * Time: 13:29.
 */

namespace Modules\Basic\Http\Services;

use App\Http\Requests\Request;

class BasicService
{
    /**
     * @return bool
     */
    public function isLayerActive(Request $request, $whitelableLayer)
    {
        // todo: check the db-url and the request-url

//        dd($whitelableLayer, 'asd');
//        if(){
//
//        }
        return true;
    }
}
