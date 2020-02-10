<?php

namespace App\Http\Middleware;

use App\Services\Flag\Src\Flag;
use Closure;
use Illuminate\Support\Facades\Auth;

class StepMiddleware
{

    public function handle($request, Closure $next, $guard = null)
    {
        if (!Auth::guard($guard)->check()) {
            return redirect('/');
        }

        if (Auth::guard($guard)->user()->hasRole(Flag::ADMINISTRATOR_ROLE)) {
            return $next($request);
        }

        if (Auth::guard($guard)->user()->hasRole(Flag::EXECUTIVE_ROLE)) {
            return $next($request);
        }

        return $next($request);
    }
}
