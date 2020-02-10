<?php

/**
 * Created by PhpStorm.
 * User: goldoni
 * Date: 24.09.18
 * Time: 23:55.
 */

namespace App\Repositories\Criteria;

use App\Services\Flag\Src\Flag;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

/**
 * Class WithTrashed.
 */
class WithTrashed implements CriterionInterface
{
    /**
     * @param $model
     */
    public function apply($model): Builder
    {
        if (Auth::guard('web')->user()->hasRole(Flag::ADMINISTRATOR_ROLE)) {
            return $model->withTrashed();
        }

        return $model->newQuery();
    }
}
