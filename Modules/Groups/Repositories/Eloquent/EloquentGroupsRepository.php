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

    public function updateCurrent(Group $group, array $current, int $whitelabelId)
    {
        Group::where('current', true)->where('whitelabel_id', $whitelabelId)
            ->update(['current' => false]);

        $group->update($current);

        return $group;
    }
}
