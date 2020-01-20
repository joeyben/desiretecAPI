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
    public function isLayerActive($request, $whitelableLayer) {

        // todo: check the db-url and the request-url
        if($whitelableLayer['layer']['active'] == 1){
            if($whitelableLayer['layer_url'] == $request->root()){
                return true;
            } else {
                return false;
            }
        }
    }

}
