<?php

namespace App\Http\Middleware;

use Closure;

class UpdateLanguage
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
        if ($request->hasHeader('wl-locale') && null !== $request->header('wl-locale')) {
            session()->put('wl-locale', $request->header('wl-locale'));
        }

        if ($request->hasHeader('wl-id') && null !== $request->header('wl-id')) {
            session()->put('wl-id', $request->header('wl-id'));
        }

        return $next($request);
    }
}
