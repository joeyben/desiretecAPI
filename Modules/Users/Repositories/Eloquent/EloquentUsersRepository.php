<?php

/**
 * Created by PhpStorm.
 * User: goldoni
 * Date: 24.09.18
 * Time: 21:18.
 */

namespace Modules\Users\Repositories\Eloquent;

use App\Models\Access\User\User;
use App\Repositories\RepositoryAbstract;
use Modules\Users\Repositories\Contracts\UsersRepository;

/**
 * Class EloquentPostsRepository.
 */
class EloquentUsersRepository extends RepositoryAbstract implements UsersRepository
{
    public function model()
    {
        return User::class;
    }
}
