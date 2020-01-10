<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Support\Facades\Auth;
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
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            if ($request->hasHeader('authorization')) {
                JWTAuth::parseToken()->authenticate();
            } else {
                $rawToken = $request->cookie('access_token');
                $token = new Token($rawToken);
                $payload = JWTAuth::decode($token);
                Auth::loginUsingId($payload['id']);
            }
        } catch (Exception $e) {
            if ($e instanceof TokenInvalidException){
                return response()->json(['status' => 'Token is Invalid']);
            }else if ($e instanceof TokenExpiredException){
                return response()->json(['status' => 'Token is Expired']);
            }else{
                return response()->json(['status' => 'Authorization Token not found']);
            }
        }
        return $next($request);
    }
}
