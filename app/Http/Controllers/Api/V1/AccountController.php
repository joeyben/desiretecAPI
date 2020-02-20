<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Contracts\AccountControllerInterface;
use App\Http\Requests\Frontend\User\ChangePasswordRequest;
use App\Http\Requests\Frontend\User\UpdateProfileRequest;
use App\Repositories\Frontend\Access\User\UserRepository;

class AccountController extends APIController implements AccountControllerInterface
{
    protected $repository;
    /**
     * @var \App\Repositories\Frontend\Access\User\UserRepository
     */
    private $user;

    public function __construct(UserRepository $repository, UserRepository $user)
    {
        $this->repository = $repository;
        $this->user = $user;
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

    public function changePassword(ChangePasswordRequest $request)
    {
        try {
            $this->user->changePassword($request->all());

            return $this->respondUpdated('Account updated successfully');
        } catch (Exception $e) {
            return $this->respondWithError($e);
        }
    }
}
