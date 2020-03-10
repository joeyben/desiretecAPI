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
class Like
{
    /**
     * @var string
     */
    private $column;
    /**
     * @var string
     */
    private $value;

    public function __construct(string $column, string $value = null)
    {
        $this->column = $column;
        $this->value = $value;
    }

    public function apply($model): Builder
    {
        return null === $this->value ? $model->newQuery() : $model->where($this->column, 'like', '%' . $this->value . '%');
    }
}
