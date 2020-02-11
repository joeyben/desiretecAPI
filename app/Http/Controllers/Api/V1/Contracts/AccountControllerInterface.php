<?php

namespace App\Http\Controllers\Api\V1\Contracts;

use App\Http\Requests\Frontend\User\UpdateProfileRequest;

interface AccountControllerInterface
{
    public function update(UpdateProfileRequest $request, int $id);
}
