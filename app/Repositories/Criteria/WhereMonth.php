<?php

/**
 * Created by PhpStorm.
 * User: goldoni
 * Date: 01.03.19
 * Time: 12:38.
 */

namespace App\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class WhereMonth.
 */
class WhereMonth
{
    /**
     * @var string|null
     */
    private $month;

    /**
     * WhereMonth constructor.
     */
    public function __construct(string $month = null)
    {
        $this->month = $month;
    }

    /**
     * @param $model
     */
    public function apply($model): Builder
    {
        return null === $this->month ? $model->newQuery() : $model->whereMonth('created_at', '=', $this->month);
    }
}
