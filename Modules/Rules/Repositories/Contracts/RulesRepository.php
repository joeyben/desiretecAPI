<?php

namespace Modules\Rules\Repositories\Contracts;

use Modules\Rules\Entities\Group;

interface RulesRepository
{
    public function updateStatus($rule, array $status, int $whitelabelId);
}
