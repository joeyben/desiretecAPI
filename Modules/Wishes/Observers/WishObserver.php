<?php

namespace Modules\Wishes\Observers;

use Illuminate\Support\Facades\Auth;
use Modules\Wishes\Entities\Wish;

class WishObserver
{
    /**
     * Handle the wish "created" event.
     *
     * @param \Modules\Wishes\Entities\Wish $wish
     */
    public function creating(Wish $wish)
    {
        if (Auth::guard('web')->check()) {
            abort_if(Auth::guard('web')->user()->cannot('create', $wish), 403, 'Forbidden. The user is authenticated, but does not have the permissions to perform an action. Please contact your Support');
        }
    }

    /**
     * Handle the wish "updated" event.
     *
     * @param \Modules\Wishes\Entities\Wish $wish
     */
    public function updating(Wish $wish)
    {
        abort_if(Auth::guard('web')->user()->cannot('update', $wish), 403, 'Forbidden. The user is authenticated, but does not have the permissions to perform an action. Please contact your Support');
    }

    /**
     * Handle the wish "deleted" event.
     *
     * @param \Modules\Wishes\Entities\Wish $wish
     */
    public function deleting(Wish $wish)
    {
        abort_if(true, 403, 'Forbidden. The user is authenticated, but does not have the permissions to perform an action. Please contact your Support');
    }

    /**
     * Handle the wish "restored" event.
     *
     * @param \Modules\Wishes\Entities\Wish $wish
     */
    public function restoring(Wish $wish)
    {
        abort_if(true, 403, 'Forbidden. The user is authenticated, but does not have the permissions to perform an action. Please contact your Support');
    }

    /**
     * Handle the wish "force deleted" event.
     *
     * @param \Modules\Wishes\Entities\Wish $wish
     */
    public function forceDeleted(Wish $wish)
    {
        abort_if(true, 403, 'Forbidden. The user is authenticated, but does not have the permissions to perform an action. Please contact your Support');
    }
}