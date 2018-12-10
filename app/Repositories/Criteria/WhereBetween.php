<?php

/**
 * Created by PhpStorm.
 * User: goldoni
 * Date: 10.12.18
 * Time: 11:55
 */

namespace App\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class WhereBetween
 *
 * @package \App\Repositories\Criteria
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
     *
     * @param string      $column
     * @param string|null $start
     * @param string|null $end
     */
    public function __construct(string $column, string $start = null, string $end = null)
    {
        $this->start = $start;
        $this->end = $end;
        $this->column = $column;
    }

    /**
     * @param $model
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply($model): Builder
    {
        return is_null($this->start) || is_null($this->end) ? $model : $model->whereBetween($this->column, [$this->start, $this->end]);
    }

}
