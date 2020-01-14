<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\ApiLoginRequest;
use App\Http\Requests\ApiRegisterRequest;
use App\Models\Access\Role\Role;
use App\Models\Access\User\User;
use App\Services\Flag\Src\Flag;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends APIController
{
    /**
     * @var \Illuminate\Auth\AuthManager
     */
    private $auth;

    /**
     * Create a new AuthController instance.
     *
     * @param \Illuminate\Auth\AuthManager $auth
     */
    public function __construct(AuthManager $auth)
    {
        $this->auth = $auth;
    }

    public function login(ApiLoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return $this->throwValidation(trans('api.messages.login.failed'));
            }

        } catch (\Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }

        return $this->respond([
            'message'   => trans('api.messages.login.success'),
            'access_token'     => $token,
        ])->cookie('access_token', $token, 3600);
    }

    public function register(ApiRegisterRequest $request)
    {
        $user = User::create([
            'email' => $request->get('email'),
        ]);

        $user->attachRole(Role::where('name', Flag::USER_ROLE)->first());

        $user->storeToken();

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user','token'),201);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        try {
            $token = JWTAuth::getToken();

            if ($token) {
                JWTAuth::invalidate($token);
            }
        } catch (JWTException $e) {
            return $this->respondInternalError($e->getMessage());
        }

        return $this->respond([
            'message'   => trans('api.messages.logout.success'),
        ]);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $token = JWTAuth::getToken();

        if (!$token) {
            $this->respondUnauthorized(trans('api.messages.refresh.token.not_provided'));
        }

        try {
            $refreshedToken = JWTAuth::refresh($token);
        } catch (JWTException $e) {
            return $this->respondInternalError($e->getMessage());
        }

        return $this->respond([
            'status' => trans('api.messages.refresh.status'),
            'token'  => $refreshedToken,
        ])->cookie('access_token', $refreshedToken, 3600);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }
}
