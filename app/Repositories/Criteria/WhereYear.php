<?php

/**
 * Created by PhpStorm.
 * User: goldoni
 * Date: 01.03.19
 * Time: 12:22.
 */

namespace App\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class WhereYear.
 */
class WhereYear
{
    /**
     * @var string|null
     */
    private $year;

    /**
     * Filter constructor.
     *
     * @param string|null $year
     */
    public function __construct(string $year = null)
    {
        $this->year = $year;
    }

    /**
     * @param $model
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply($model): Builder
    {
        return null === $this->year ? $model->newQuery() : $model->whereYear('created_at', '=', $this->year);
    }
}
