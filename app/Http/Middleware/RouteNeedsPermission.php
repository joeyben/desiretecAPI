<?php

namespace App\Http\Middleware;

use Closure;

/**
 * Class RouteNeedsRole.
 */
class RouteNeedsPermission
{
    /**
     * @param $request
     * @param $permission
     * @param bool $needsAll
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $permission, $needsAll = false)
    {
        /*
         * Permission array
         */
        if (false !== mb_strpos($permission, ';')) {
            $permissions = explode(';', $permission);
            $access = access()->allowMultiple($permissions, ('true' === $needsAll ? true : false));
        } else {
            /**
             * Single permission.
             */
            $access = access()->allow($permission);
        }

        if (!$access) {
            return redirect()
                ->route('frontend.index')
                ->withFlashDanger(trans('auth.general_error'));
        }

        return $next($request);
    }
}
