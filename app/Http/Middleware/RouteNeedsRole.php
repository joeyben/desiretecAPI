<?php

namespace App\Http\Middleware;

use Closure;

/**
 * Class RouteNeedsRole.
 */
class RouteNeedsRole
{
    /**
     * @param $request
     * @param $role
     * @param bool $needsAll
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $role, $needsAll = false)
    {
        /*
         * Roles array
         */
        if (false !== mb_strpos($role, ';')) {
            $roles = explode(';', $role);
            $access = access()->hasRoles($roles, ('true' === $needsAll ? true : false));
        } else {
            /**
             * Single role.
             */
            $access = access()->hasRole($role);
        }

        if (!$access) {
            return redirect()
                ->route('frontend.index')
                ->withFlashDanger(trans('auth.general_error'));
        }

        return $next($request);
    }
}
