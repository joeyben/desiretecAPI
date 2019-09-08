<?php

namespace Modules\Rules\Repositories\Contracts;

interface RulesRepository
{
    public function updateStatus($rule, array $status, int $whitelabelId);
}
