<?php

namespace Modules\Autooffers\Repositories\Contracts;

interface AutooffersRepository
{
    public function updateStatus($rule, array $status, int $whitelabelId);
}
