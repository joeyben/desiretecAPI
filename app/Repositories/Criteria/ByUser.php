<?php

/**
 * Created by PhpStorm.
 * User: goldoni
 * Date: 24.09.18
 * Time: 22:40.
 */

namespace App\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class ByUser.
 */
class ByUser implements CriterionInterface
{
    /**
     * @var int
     */
    private $userId;

    /**
     * ByUser constructor.
     */
    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    /**
     * @param $model
     */
    public function apply($model): Builder
    {
        return $model->where('user_id', $this->userId);
    }
}
