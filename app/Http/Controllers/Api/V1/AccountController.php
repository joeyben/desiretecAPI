<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Contracts\AccountControllerInterface;
use App\Http\Requests\Frontend\User\UpdateProfileRequest;
use App\Repositories\Frontend\Access\User\UserRepository;

class AccountController extends APIController implements AccountControllerInterface
{
    protected $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function update(UpdateProfileRequest $request, int $id)
    {
        try {
            $this->repository->updateProfile($id, $request->all());

            return $this->respondUpdated('account updated successfully');

        } catch (Exception $e) {
            return $this->respondWithError($e);
        }
    }
}
