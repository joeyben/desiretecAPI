<?php
/**
 * Created by PhpStorm.
 * User: gencgruda
 * Date: 2019-12-23
 * Time: 13:29
 */

namespace Modules\Basic\Http\Services;


use App\Http\Requests\Request;

class BasicService{

    /**
     * @param Request $request
     * @return bool
     */
    public function isLayerActive(Request $request): bool{
        // todo: check the db-url and the request-url
    }

}
