<?php
/**
 * Created by PhpStorm.
 * User: gencgruda
 * Date: 2019-12-23
 * Time: 13:41
 */

namespace Modules\Basic\Http\Repositories;


use http\Env\Request;

class BasicRepository
{

    public function getLayersData(Request $request){
        // todo #1: Get the Data as an array from the DB for the current WL
        // todo #2: loop the data and call the service-function isLayerActive() and add the param "active"

    }
}
