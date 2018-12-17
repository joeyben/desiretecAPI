<?php

/**
 * Created by PhpStorm.
 * User: goldoni
 * Date: 24.09.18
 * Time: 21:18.
 */

namespace Modules\Groups\Repositories\Eloquent;

use App\Repositories\RepositoryAbstract;
use Modules\Groups\Entities\Group;
use Modules\Groups\Repositories\Contracts\GroupsRepository;

/**
 * Class EloquentPostsRepository.
 */
class EloquentGroupsRepository extends RepositoryAbstract implements GroupsRepository
{
    public function model()
    {
        return Group::class;
    }
}
