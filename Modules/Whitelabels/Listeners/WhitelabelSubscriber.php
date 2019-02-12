<?php

namespace Modules\Whitelabels\Listeners;

use App\Models\Access\Role\Role;
use App\Services\Flag\Src\Flag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Modules\Whitelabels\Entities\Whitelabel;
use Modules\Whitelabels\Notifications\CreateWhitelabelNotification;

class WhitelabelSubscriber
{
    /**
     * @var \Modules\Whitelabels\Entities\Whitelabel
     */
    private $whitelabel;

    /**
     * Create the event listener.
     *
     * @param \Modules\Whitelabels\Entities\Whitelabel $whitelabel
     */
    public function __construct(Whitelabel $whitelabel)
    {
        $this->whitelabel = $whitelabel;
    }

    /**
     * @param $events
     */
    public function subscribe($events)
    {
        $events->listen('eloquent.created: Modules\Whitelabels\Entities\Whitelabel', [$this, 'onCreatedWhitelabel']);
        $events->listen('eloquent.deleted: Modules\Whitelabels\Entities\Whitelabel', [$this, 'onDeletedWhitelabel']);
        $events->listen('eloquent.restored: Modules\Whitelabels\Entities\Whitelabel', [$this, 'onRestoredWhitelabel']);
    }

    public function onCreatedWhitelabel(Whitelabel $whitelabel)
    {
        $users = Role::where('name', Flag::ADMINISTRATOR_ROLE)->first()->users()->get();

        Notification::send($users, new CreateWhitelabelNotification($whitelabel));
    }

    public function onDeletedWhitelabel(Whitelabel $whitelabel)
    {
        $admins = Role::where('name', 'Administrator')->first()->users()->get();

        foreach ($admins as $admin) {
            createNotification('<span class="badge badge-flat border-danger text-danger-600 rounded-0 mr-2"> Deleted </span> <strong> Whitelabel (</strong>' . $whitelabel->display_name . '<strong>)</strong> has been <strong>successfully deleted</strong> by: <u class="text-primary-800 cursor-pointer">' . Auth::guard('web')->user()->first_name . ' ' . Auth::guard('web')->user()->last_name . '</u>', $admin->id);
        }
    }

    public function onRestoredWhitelabel(Whitelabel $whitelabel)
    {
        $admins = Role::where('name', 'Administrator')->first()->users()->get();

        foreach ($admins as $admin) {
            createNotification('<span class="badge badge-flat border-info text-info-600 rounded-0 mr-2"> Restored </span> <strong> Whitelabel (</strong>' . $whitelabel->display_name . '<strong>)</strong> has been <strong>successfully restored</strong> by: <u class="text-primary-800 cursor-pointer">' . Auth::guard('web')->user()->first_name . ' ' . Auth::guard('web')->user()->last_name . '</u>', $admin->id);
        }
    }
}
