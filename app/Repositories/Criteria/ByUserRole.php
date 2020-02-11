<?php

/**
 * Created by PhpStorm.
 * User: goldoni
 * Date: 24.09.18
 * Time: 23:55.
 */

namespace App\Repositories\Criteria;

use App\Services\Flag\Src\Flag;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

/**
 * Class WithTrashed.
 */
class ByUserRole implements CriterionInterface
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
        if (Auth::user()->hasRole(Flag::USER_ROLE)) {
            return $model->where('wishes.created_by', $this->userId);
        }

        $groups = Auth::user()->groups()->get()->pluck('id')->all();

        return $model->whereIn('wishes.group_id', $groups);
    }
}
