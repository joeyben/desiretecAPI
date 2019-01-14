<?php

/**
 * Created by PhpStorm.
 * User: goldoni
 * Date: 24.09.18
 * Time: 21:18.
 */

namespace Modules\Roles\Repositories\Eloquent;

use App\Models\Access\Role\Role;
use App\Repositories\RepositoryAbstract;
use Modules\Roles\Repositories\Contracts\RolesRepository;

/**
 * Class EloquentPostsRepository.
 */
class EloquentRolesRepository extends RepositoryAbstract implements RolesRepository
{
    public function model()
    {
        return Role::class;
    }
}
