<?php

namespace App\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class Has.
 */
class Has
{
    private $relation;

    /**
     * Has constructor.
     *
     * @param $relation
     */
    public function __construct($relation)
    {
        $this->relation = $relation;
    }

    /**
     * Check if entity has relation.
     *
     * @param $model
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply($model): Builder
    {
        return $model->has($this->relation);
    }
}
