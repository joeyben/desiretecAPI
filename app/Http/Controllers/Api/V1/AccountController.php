<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Contracts\AccountControllerInterface;
use App\Http\Requests\Frontend\User\ChangePasswordRequest;
use App\Http\Requests\Frontend\User\ResetLinkEmailRequest;
use App\Http\Requests\Frontend\User\ResetPasswordRequest;
use App\Http\Requests\Frontend\User\UpdateProfileRequest;
use App\Notifications\Frontend\Auth\ApiUserNeedsPasswordReset;
use App\Notifications\Frontend\Auth\UserNeedsPasswordReset;
use App\Repositories\Frontend\Access\User\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

    public function resetPassword(ResetPasswordRequest $request)
    {
        try {
            $this->user->resetPassword($request->all());

            return $this->respondUpdated('Passwort erfolgreich aktualisiert');
        } catch (Exception $e) {
            return $this->respondWithError($e);
        }
    }


    public function sendResetLinkEmail(ResetLinkEmailRequest $request)
    {
        $user = $this->repository->findByEmail($request->get('email'));

        if (!$user) {
            return $this->respondNotFound(trans('api.messages.forgot_password.validation.email_not_found'));
        }

        $user->notify(new ApiUserNeedsPasswordReset($user->token->token, $request->get('host'), $request->get('email')));

        return $this->respond([
            'status'    => 'ok',
            'message'   => trans('api.messages.forgot_password.success'),
        ]);
    }
}
