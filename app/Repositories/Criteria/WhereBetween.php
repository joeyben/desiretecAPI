<?php

/**
 * Created by PhpStorm.
 * User: goldoni
 * Date: 10.12.18
 * Time: 11:55.
 */

namespace App\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class WhereBetween.
 */
class WhereBetween
{
    /**
     * @var string
     */
    private $start;
    /**
     * @var string
     */
    private $end;
    /**
     * @var string
     */
    private $column;

    /**
     * WhereBetween constructor.
     */
    public function __construct(string $column, string $start = null, string $end = null)
    {
        $this->start = $start;
        $this->end = $end;
        $this->column = $column;
    }

    /**
     * @param $model
     */
    public function apply($model): Builder
    {
        return null === $this->start || null === $this->end ? $model->newQuery() : $model->whereBetween($this->column, [$this->start, $this->end]);
    }
}
