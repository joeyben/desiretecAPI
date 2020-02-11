<?php

namespace App\Http\Controllers\Api\V1\Contracts;

interface AutooffersControllerInterface
{
    public function list(int $wishId);

    public function listTt(int $wishId);
}
