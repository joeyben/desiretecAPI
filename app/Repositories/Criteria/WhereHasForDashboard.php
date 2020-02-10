<?php

/**
 * Created by PhpStorm.
 * User: goldoni
 * Date: 28.02.19
 * Time: 17:22.
 */

namespace App\Repositories\Criteria;

use App\Services\Flag\Src\Flag;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

/**
 * Class WhereHasForDashboard.
 */
class WhereHasForDashboard
{
    /**
     * @var string
     */
    private $relation;

    private $closure;

    /**
     * WhereHasForDashboard constructor.
     *
     * @param $closure
     */
    public function __construct(string $relation, $closure)
    {
        $this->relation = $relation;
        $this->closure = $closure;
    }

    public function apply($model): Builder
    {
        return Auth::guard('web')->user()->hasRole(Flag::EXECUTIVE_ROLE) ? $model->newQuery() : $model->whereHas($this->relation, $this->closure);
    }
}
