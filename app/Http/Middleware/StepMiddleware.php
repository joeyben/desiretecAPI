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
            $step = Auth::guard($guard)->user()->whitelabels()->first()->state;

            if ($step >= Flag::MAX_STEP - 2) {
                return $next($request);
            }

            return redirect()->route('admin.step', [$step]);
        }

        return $next($request);
    }
}
