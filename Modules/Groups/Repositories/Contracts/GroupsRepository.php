<?php

namespace Modules\Groups\Repositories\Contracts;


use Modules\Groups\Entities\Group;

interface GroupsRepository
{
    public function updateCurrent(Group $group, array $current, int $whitelabelId);
}
