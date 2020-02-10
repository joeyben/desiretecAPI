<?php

namespace Modules\Categories\Observers;

use BrianFaust\Categories\Models\Category;
use Illuminate\Support\Facades\Auth;

class CategoryObserver
{
    /**
     * Handle the category "created" event.
     */
    public function creating(Category $category)
    {
        abort_if(Auth::guard('web')->user()->cannot('create', $category), 403, 'Forbidden. The user is authenticated, but does not have the permissions to perform an action. Please contact your Support');
    }

    /**
     * Handle the category "updated" event.
     */
    public function updating(Category $category)
    {
        abort_if(Auth::guard('web')->user()->cannot('update', $category), 403, 'Forbidden. The user is authenticated, but does not have the permissions to perform an action. Please contact your Support');
    }

    /**
     * Handle the category "deleted" event.
     */
    public function deleting(Category $category)
    {
        abort_if(Auth::guard('web')->user()->cannot('delete', $category), 403, 'Forbidden. The user is authenticated, but does not have the permissions to perform an action. Please contact your Support');
    }

    /**
     * Handle the category "restored" event.
     */
    public function restoring(Category $category)
    {
        abort_if(false, 403, 'Forbidden. The user is authenticated, but does not have the permissions to perform an action. Please contact your Support');
    }

    /**
     * Handle the category "force deleted" event.
     */
    public function forceDeleted(Category $category)
    {
        abort_if(false, 403, 'Forbidden. The user is authenticated, but does not have the permissions to perform an action. Please contact your Support');
    }
}
