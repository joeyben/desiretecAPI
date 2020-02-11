<?php
/**
 * Created by PhpStorm.
 * User: gencgruda
 * Date: 2019-12-23
 * Time: 13:41.
 */

namespace Modules\Basic\Http\Repositories;

use http\Env\Request;
use Modules\Basic\Http\Services\BasicService;

class BasicRepository
{
    protected $basicService;

    /**
     * @param \Modules\Autooffers\Repositories\AutooffersRepository $autooffers
     */
    public function __construct(BasicService $service)
    {
        $this->basicService = $service;
    }

    public function getLayersData(Request $request, $whitelabel)
    {
        $layerData = [];
        foreach ($whitelabel['whitelable_layer'] as $whitelableLayer) {
            $layer['name'] = $whitelableLayer['layer']['category'];
            $layer['active'] = $this->basicService->isLayerActive($request, $whitelableLayer);
            array_push($layerData, $layer);
        }
        //  dd($layerData);
        // todo #2: loop the data and call the service-function isLayerActive() and add the param "active"
    }
}
