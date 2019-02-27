<?php

/**
 * Created by PhpStorm.
 * User: goldoni
 * Date: 27.02.19
 * Time: 14:20
 */

namespace App\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class GroupBy
 *
 * @package \App\Repositories\Criteria
 */
class GroupBy
{
    /**
     * @var string
     */
    private $column;

    /**
     * GroupBy constructor.
     *
     * @param string $column
     */
    public function __construct(string $column)
    {
        $this->column = $column;
    }

    /**
     * @param $model
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply($model): Builder
    {
        return null === $this->column ? $model->newQuery() : $model->groupBy($this->column);
    }
}
