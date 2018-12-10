<?php

/**
 * Created by PhpStorm.
 * User: goldoni
 * Date: 10.12.18
 * Time: 13:36.
 */

namespace App\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class Where.
 */
class Where
{
    /**
     * @var string
     */
    private $column;
    /**
     * @var string
     */
    private $value;

    /**
     * Where constructor.
     *
     * @param string $column
     * @param string $value
     */
    public function __construct(string $column, string $value = null)
    {
        $this->column = $column;
        $this->value = $value;
    }

    /**
     * @param $model
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply($model): Builder
    {
        return null === $this->value ? $model : $model->where($this->column, $this->value);
    }
}
