<?php

namespace Modules\Rules\Listeners;

use App\Models\Access\Role\Role;
use Illuminate\Support\Facades\Auth;
use Modules\Rules\Entities\Rule;

class RuleSubscriber
{
    /**
     * @var \Modules\Rules\Entities\Rule
     */
    private $rule;

    /**
     * Create the event listener.
     */
    public function __construct(Rule $rule)
    {
        $this->rule = $rule;
    }

    /**
     * @param $events
     */
    public function subscribe($events)
    {
        $events->listen('eloquent.created: Modules\Rules\Entities\Rule', [$this, 'onCreatedRule']);
        $events->listen('eloquent.deleted: Modules\Rules\Entities\Rule', [$this, 'onDeletedRule']);
        $events->listen('eloquent.restored: Modules\Rules\Entities\Rule', [$this, 'onRestoredRule']);
    }

    public function onCreatedRule(Rule $rule)
    {
        $admins = Role::where('name', 'Administrator')->first()->users()->where('users.id', '!=', Auth::guard('web')->user()->id)->get();
        $user = $rule->user()->first();

        foreach ($admins as $admin) {
            createNotification('<span class="badge badge-flat border-success text-success-600 rounded-0 mr-2"> Created </span>  <strong> Rule (</strong>' . $rule->type . '<strong>)</strong> has been <strong>successfully created</strong> by: <u class="text-primary-800 cursor-pointer">' . Auth::guard('web')->user()->first_name . ' ' . Auth::guard('web')->user()->last_name . '</u>', $admin->id, Auth::guard('web')->user()->id);
        }
        createNotification('<span class="badge badge-flat border-success text-success-600 rounded-0 mr-2"> Created </span>  <strong> Rule (</strong>' . $rule->type . '<strong>)</strong> has been <strong>successfully created</strong> by: <u class="text-primary-800 cursor-pointer">' . Auth::guard('web')->user()->first_name . ' ' . Auth::guard('web')->user()->last_name . '</u>', $user->id, Auth::guard('web')->user()->id);

        if ((int) $user->id !== (int) Auth::guard('web')->user()->id) {
            createNotification('<span class="badge badge-flat border-success text-success-600 rounded-0 mr-2"> Created </span>  <strong> Rule (</strong>' . $rule->type . '<strong>)</strong> has been <strong>successfully created</strong> by: <u class="text-primary-800 cursor-pointer">' . Auth::guard('web')->user()->first_name . ' ' . Auth::guard('web')->user()->last_name . '</u>', Auth::guard('web')->user()->id, Auth::guard('web')->user()->id);
        }
    }

    public function onDeletedRule(Rule $rule)
    {
        $admins = Role::where('name', 'Administrator')->first()->users()->where('users.id', '!=', Auth::guard('web')->user()->id)->get();
        $user = $rule->user()->first();

        foreach ($admins as $admin) {
            createNotification('<span class="badge badge-flat border-danger text-danger-600 rounded-0 mr-2"> Deleted </span>  <strong> Rule (</strong>' . $rule->type . '<strong>)</strong> has been <strong>successfully deleted</strong> by: <u class="text-primary-800 cursor-pointer">' . Auth::guard('web')->user()->first_name . ' ' . Auth::guard('web')->user()->last_name . '</u>', $admin->id, Auth::guard('web')->user()->id);
        }
        createNotification('<span class="badge badge-flat border-danger text-danger-600 rounded-0 mr-2"> Deleted </span>  <strong> Rule (</strong>' . $rule->type . '<strong>)</strong> has been <strong>successfully deleted</strong> by: <u class="text-primary-800 cursor-pointer">' . Auth::guard('web')->user()->first_name . ' ' . Auth::guard('web')->user()->last_name . '</u>', $user->id, Auth::guard('web')->user()->id);

        if ((int) $user->id !== (int) Auth::guard('web')->user()->id) {
            createNotification('<span class="badge badge-flat border-danger text-danger-600 rounded-0 mr-2"> Deleted </span>  <strong> Rule (</strong>' . $rule->type . '<strong>)</strong> has been <strong>successfully deleted</strong> by: <u class="text-primary-800 cursor-pointer">' . Auth::guard('web')->user()->first_name . ' ' . Auth::guard('web')->user()->last_name . '</u>', Auth::guard('web')->user()->id, Auth::guard('web')->user()->id);
        }
    }

    public function onRestoredRule(Rule $rule)
    {
        $admins = Role::where('name', 'Administrator')->first()->users()->where('users.id', '!=', Auth::guard('web')->user()->id)->get();
        $user = $rule->user()->first();

        foreach ($admins as $admin) {
            createNotification('<span class="badge badge-flat border-info text-info-600 rounded-0 mr-2"> Restored </span>  <strong> Rule (</strong>' . $rule->type . '<strong>)</strong> has been <strong>successfully restored</strong> by: <u class="text-primary-800 cursor-pointer">' . Auth::guard('web')->user()->first_name . ' ' . Auth::guard('web')->user()->last_name . '</u>', $admin->id, Auth::guard('web')->user()->id);
        }
        createNotification('<span class="badge badge-flat border-info text-info-600 rounded-0 mr-2"> Restored </span>  <strong> Rule (</strong>' . $rule->type . '<strong>)</strong> has been <strong>successfully restored</strong> by: <u class="text-primary-800 cursor-pointer">' . Auth::guard('web')->user()->first_name . ' ' . Auth::guard('web')->user()->last_name . '</u>', $user->id, Auth::guard('web')->user()->id);

        if ((int) $user->id !== (int) Auth::guard('web')->user()->id) {
            createNotification('<span class="badge badge-flat border-info text-info-600 rounded-0 mr-2"> Restored </span>  <strong> Rule (</strong>' . $rule->type . '<strong>)</strong> has been <strong>successfully restored</strong> by: <u class="text-primary-800 cursor-pointer">' . Auth::guard('web')->user()->first_name . ' ' . Auth::guard('web')->user()->last_name . '</u>', Auth::guard('web')->user()->id, Auth::guard('web')->user()->id);
        }
    }
}
