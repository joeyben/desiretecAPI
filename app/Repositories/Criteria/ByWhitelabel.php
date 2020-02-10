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
     * @var string
     */
    private $table;

    /**
     * ByWhitelabel constructor.
     */
    public function __construct(string $table = 'wishes')
    {
        $this->table = $table;
    }

    /**
     * @param $model
     */
    public function apply($model): Builder
    {
        $whitelabels = Auth::guard('web')->user()->whitelabels()->get()->pluck('id')->all();

        return Auth::guard('web')->user()->hasRole('Administrator') ? $model->newQuery() : $model->whereIn($this->table . '.whitelabel_id', $whitelabels);
    }
}
