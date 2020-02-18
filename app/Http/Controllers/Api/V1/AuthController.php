<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\ApiLinkRequest;
use App\Http\Requests\ApiLoginRequest;
use App\Http\Requests\ApiRegisterRequest;
use App\Models\Access\Role\Role;
use App\Models\Access\User\User;
use App\Models\Access\User\UserToken;
use App\Services\Flag\Src\Flag;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Token;

class AuthController extends APIController
{
    /**
     * @var \Illuminate\Auth\AuthManager
     */
    private $auth;

    protected $identifier = 'email';

    /**
     * Create a new AuthController instance.
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
            'message'          => trans('api.messages.login.success'),
            'access_token'     => $token,
        ])->cookie('access_token', $token, JWTAuth::factory()->getTTL() * 60);
    }

    public function register(ApiRegisterRequest $request)
    {
        $user = User::create([
            'email' => $request->get('email'),
        ]);

        $user->attachRole(Role::where('name', Flag::USER_ROLE)->first());

        $user->storeToken();

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user', 'token'), 201);
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
        ])->cookie('access_token', $refreshedToken, JWTAuth::factory()->getTTL() * 60);
    }

    public function me()
    {
        $result['user'] = $this->auth->user();
        $result['user']['role'] = $this->auth->user()->roles()->first()->name;
        $result['user']['isUser'] = $this->auth->user()->hasRole(Flag::USER_ROLE);
        $result['user']['isSeller'] = $this->auth->user()->hasRole(Flag::SELLER_ROLE);
        $result['user']['isExecutive'] = $this->auth->user()->hasRole(Flag::EXECUTIVE_ROLE);
        $result['user']['isAdmin'] = $this->auth->user()->hasRole(Flag::ADMINISTRATOR_ROLE);
        $result['user']['agents'] = $this->auth->user()->agents()->get();
        $result['user']['currentAgents'] = null;

        if ($this->auth->user()->hasRole(Flag::SELLER_ROLE) && Auth::guard('agent')->check()) {
            $result['user']['currentAgent'] = Auth::guard('agent')->user();
        }

        return $this->respond(['user' => $this->auth->user(), 'status' => Flag::STATUS_CODE_SUCCESS]);
    }

    public function ckeckRole(Request $request)
    {
        return $this->respond(['role' => $this->auth->user()->hasRole($request->get('role')), 'status' => 200]);
    }

    public function sendLoginEmail(ApiLinkRequest $request)
    {
        try {
            $user = $this->getUserByIdentifier($request->get($this->identifier));
            $user->storeToken()->sendApiTokenLink([
                'email' => trim($user->email),
                'host'  => $request->get('host')
            ]);
        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }

        return $this->respond(['message' => 'Wir haben Ihren Login Link per E-Mail gesendet!', 'status' => 200]);
    }

    protected function getUserByIdentifier($value)
    {
        return User::where($this->identifier, $value)->firstOrFail();
    }

    public function token(Request $request, UserToken $token)
    {
        if (!$token->belongsToEmail($request->email)) {
            return $this->respondInternalError('Invalid login link!');
        }

        Auth::login($token->user, true);
        $jwtToken = JWTAuth::fromUser($token->user);

        return $this->respond(['access_token' => JWTAuth::fromUser($token->user), 'status' => 200])
            ->cookie('access_token', $jwtToken, JWTAuth::factory()->getTTL() * 60);
    }
}
