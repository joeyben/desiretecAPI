<?php

namespace Modules\Groups\Observers;

use Illuminate\Support\Facades\Auth;
use Modules\Groups\Entities\Group;

class GroupObserver
{
    /**
     * Handle the group "created" event.
     */
    public function creating(Group $group)
    {
        abort_if(Auth::guard('web')->user()->cannot('create', Group::class), 403, 'Forbidden. The user is authenticated, but does not have the permissions to perform an action. Please contact your Support');
    }

    /**
     * Handle the group "updated" event.
     */
    public function updating(Group $group)
    {
        abort_if(Auth::guard('web')->user()->cannot('update', $group), 403, 'Forbidden. The user is authenticated, but does not have the permissions to perform an action. Please contact your Support');
    }

    /**
     * Handle the group "deleted" event.
     */
    public function deleting(Group $group)
    {
        abort_if(Auth::guard('web')->user()->cannot('delete', $group), 403, 'Forbidden. The user is authenticated, but does not have the permissions to perform an action. Please contact your Support');
    }

    /**
     * Handle the group "restored" event.
     */
    public function restoring(Group $group)
    {
        abort_if(Auth::guard('web')->user()->cannot('restore', $group), 403, 'Forbidden. The user is authenticated, but does not have the permissions to perform an action. Please contact your Support');
    }

    /**
     * Handle the group "force deleted" event.
     */
    public function forceDeleted(Group $group)
    {
        abort_if(Auth::guard('web')->user()->cannot('forceDelete', Group::class), 403, 'Forbidden. The user is authenticated, but does not have the permissions to perform an action. Please contact your Support');
    }
}
