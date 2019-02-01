<?php

/**
 * Created by PhpStorm.
 * User: goldoni
 * Date: 01.02.19
 * Time: 15:18.
 */

namespace App\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;

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
     *
     * @param string|null $role
     */
    public function __construct(string $role = null)
    {
        $this->role = $role;
    }

    /**
     * @param $model
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply($model): Builder
    {
        return $model->whereHas('roles', function ($query) {
            $query->where('roles.name', $this->role);
        });
    }
}
