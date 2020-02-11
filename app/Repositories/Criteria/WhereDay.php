<?php

/**
 * Created by PhpStorm.
 * User: goldoni
 * Date: 01.03.19
 * Time: 15:49.
 */

namespace App\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class WhereDay.
 */
class WhereDay
{
    /**
     * @var string|null
     */
    private $day;

    /**
     * WhereMonth constructor.
     */
    public function __construct(string $day = null)
    {
        $this->day = $day;
    }

    /**
     * @param $model
     */
    public function apply($model): Builder
    {
        return null === $this->day ? $model->newQuery() : $model->whereDay('created_at', '=', $this->day);
    }
}
