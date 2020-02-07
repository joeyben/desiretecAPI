<?php

namespace App\Http\Controllers\Api\V1\Contracts;

Interface AutooffersControllerInterface
{
	public function list(int $wishId);

    public function listTt(int $wishId);
}
