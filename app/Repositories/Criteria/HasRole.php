<?php

/**
 * Created by PhpStorm.
 * User: goldoni
 * Date: 01.02.19
 * Time: 15:18.
 */

namespace App\Repositories\Criteria;

use App\Services\Flag\Src\Flag;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

/**
 * Class HasRole.
 */
class HasRole
{
    /**
     * @var string|null
     */
    private $role;

    /**
     * HasRole constructor.
     */
    public function __construct(string $role = null)
    {
        $this->role = $role;
    }

    /**
     * @param $model
     */
    public function apply($model): Builder
    {
        if (Auth::guard('web')->user()->hasRole(Flag::ADMINISTRATOR_ROLE)) {
            return $model->whereHas('roles', function ($query) {
                $query->where('roles.name', $this->role);
            });
        }

        return $model->newQuery();
    }
}
