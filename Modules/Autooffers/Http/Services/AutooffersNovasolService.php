<?php
/**
 * Created by PhpStorm.
 * User: gencgruda
 * Date: 2019-08-07
 * Time: 16:15
 */

namespace Modules\Autooffers\Http\Services;


use App\Models\Wishes\Wish;
use Modules\Autooffers\Repositories\AutooffersNovasolRepository;

class AutooffersNovasolService{

    public function prepareParamForNovasolApi(AutooffersNovasolRepository $autooffers, Wish $wish){
        $country_area = $autooffers->to_country_code($wish->destination);

        $params = [
            'country' => $country_area[0],
            'area' => $country_area[1],
            'company' => 'nov',
            'arrival' => str_replace(['-'], [''], $wish->earliest_start),
            'departure' => str_replace(['-'], [''], $wish->latest_return),
            'salesmarket' => '280',
            'adults' => ($wish->adults == 0) ? 1 : $wish->adults,
            //'adults' => str_replace([' Erwachsene', ' Erwachsener'],['',''], $wish->adults),
            //'children' => $wish->kids == 'Kein Kinder' ? '':str_replace(' Kinder','',$wish->kids),
            'children' => $wish->kids,
            'maxprice' => $wish->budget,
        ];

        return $params;
    }

}
