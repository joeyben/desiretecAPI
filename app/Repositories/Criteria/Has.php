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
     */
    public function apply($model): Builder
    {
        return $model->has($this->relation);
    }
}
