<?php

/**
 * Created by PhpStorm.
 * User: goldoni
 * Date: 24.09.18
 * Time: 22:40.
 */

namespace App\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class ByWhitelabelLanguages.
 */
class ByWhitelabelLanguages implements CriterionInterface
{
    /**
     * ByWhitelabelLanguages constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param $model
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply($model): Builder
    {
        if (isWhiteLabel()) {
            $whitelabelId = getCurrentWhiteLabelId();

            return $model->whereHas('whitelabels', function ($q) use ($whitelabelId) {
                $q->where('whitelabels.id', $whitelabelId);
            });
        }

        return $model->select();
    }
}
