<?php

/**
 * Created by PhpStorm.
 * User: goldoni
 * Date: 11.12.18
 * Time: 10:19.
 */

namespace App\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

/**
 * Class ByWhitelabel.
 */
class ByWhitelabel
{
    /**
     * @param $model
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply($model): Builder
    {
        $whitelabels = Auth::guard('web')->user()->whitelabels()->get()->pluck('id')->all();

        return Auth::guard('web')->user()->hasRole('Administrator') ? $model : $model->whereIn('wishes.whitelabel_id', $whitelabels);
    }
}
