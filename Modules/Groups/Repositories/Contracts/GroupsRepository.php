<?php

namespace Modules\Groups\Repositories\Contracts;


use Modules\Groups\Entities\Group;
use Modules\Whitelabels\Entities\Whitelabel;

interface GroupsRepository
{
    public function updateCurrent(Group $group, array $current, int $whitelabelId);

    public function getWhitelabel($request): Whitelabel;
}
