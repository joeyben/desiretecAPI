<?php

/**
 * Created by PhpStorm.
 * User: goldoni
 * Date: 24.09.18
 * Time: 21:18.
 */

namespace Modules\Permissions\Repositories\Eloquent;

use App\Models\Access\Permission\Permission;
use App\Repositories\RepositoryAbstract;
use Modules\Permissions\Repositories\Contracts\PermissionsRepository;

/**
 * Class EloquentPostsRepository.
 */
class EloquentPermissionsRepository extends RepositoryAbstract implements PermissionsRepository
{
    public function model()
    {
        return Permission::class;
    }
}
