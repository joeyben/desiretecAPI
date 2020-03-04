<?php

namespace App\Http\Middleware;

use App\Services\Flag\Src\Flag;
use Closure;
use Exception;
use Illuminate\Http\Response as IlluminateResponse;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Token;

class JwtMiddleware extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            if ($request->hasHeader('authorization')) {
                JWTAuth::parseToken()->authenticate();
                $rawToken = JWTAuth::getToken();
                $payload = JWTAuth::decode($rawToken);
                Auth::guard('web')->loginUsingId($payload['sub']);

                if (Auth::guard('web')->user()->hasRole(Flag::SELLER_ROLE)) {
                    if ($request->hasHeader('c-agent') && null !== $request->hasHeader('c-agent')) {
                        Auth::guard('agent')->logout();
                        Auth::guard('agent')->loginUsingId($request->header('c-agent'));
                    }
                }

                if (Auth::guard('web')->user()->hasRole(Flag::SELLER_ROLE) && !Auth::guard('agent')->check()) {
                    if ($agent = Auth::guard('web')->user()->agents()->first()) {
                        Auth::guard('agent')->loginUsingId($agent->id);
                    }
                }
            } else {
                $rawToken = $request->cookie('access_token');
                $token = new Token($rawToken);
                $payload = JWTAuth::decode($token);
                Auth::loginUsingId($payload['sub']);

                if (Auth::user()->hasRole(Flag::SELLER_ROLE)) {
                    if ($request->hasHeader('c-agent') && null !== $request->hasHeader('c-agent')) {
                        Auth::guard('agent')->logout();
                        Auth::guard('agent')->loginUsingId((int) $request->header('c-agent'));
                    }
                }

                if (Auth::user()->hasRole(Flag::SELLER_ROLE) && !Auth::guard('agent')->check()) {
                    if ($agent = Auth::user()->agents()->first()) {
                        Auth::guard('agent')->loginUsingId($agent->id);
                    }
                }
            }
        } catch (Exception $e) {
            if ($e instanceof TokenInvalidException) {
                return response()->json(['message' => 'Token is Invalid'], IlluminateResponse::HTTP_UNAUTHORIZED);
            } elseif ($e instanceof TokenExpiredException) {
                return response()->json(['message' => 'Token is Expired'], IlluminateResponse::HTTP_UNAUTHORIZED);
            } elseif ($e instanceof TokenBlacklistedException) {
                return response()->json(['message' => 'Token is Blacklisted'], IlluminateResponse::HTTP_UNAUTHORIZED);
            } elseif ($e instanceof JWTException) {
                return response()->json(['message' => 'Need to Login Again'], IlluminateResponse::HTTP_UNAUTHORIZED);
            }

            return response()->json(['message' => 'Token missing or badly formatted'], IlluminateResponse::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
