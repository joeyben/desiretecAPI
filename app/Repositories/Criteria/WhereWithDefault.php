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
class WhereWithDefault
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
     * @param string $value
     */
    public function __construct(string $column, string $value = null)
    {
        $this->column = $column;
        $this->value = $value;
    }

    /**
     * @param $model
     */
    public function apply($model): Builder
    {

        if (null === $this->value) {
            return $model->newQuery();
        }

        if (0 === (int)$this->value) {
            return $model->whereNull('whitelabel_id');
        }

        return $model->where($this->column, $this->value);
    }
}
