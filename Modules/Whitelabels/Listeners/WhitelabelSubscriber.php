<?php

namespace Modules\Whitelabels\Listeners;

use App\Models\Access\Role\Role;
use App\Services\Flag\Src\Flag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Notification;
use Modules\Whitelabels\Entities\Whitelabel;
use Modules\Whitelabels\Notifications\CreateWhitelabelNotification;
use Modules\Whitelabels\Notifications\DeletedWhitelabelNotification;
use Modules\Whitelabels\Notifications\RestoredWhitelabelNotification;

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
        $admins = Role::where('name', Flag::ADMINISTRATOR_ROLE)->first()->users()->get();

        foreach ($admins as $admin) {
            createNotification(Lang::get('notification.deleted', ['name' => 'Whitelabel', 'url' => $whitelabel->display_name, 'user' =>  Auth::guard('web')->user()->first_name . ' ' . Auth::guard('web')->user()->last_name]), $admin->id, Auth::guard('web')->user()->id);
        }

        if (!$whitelabel->isForceDeleting()) {
            Notification::send($admins, new DeletedWhitelabelNotification($whitelabel));
        }
    }

    public function onRestoredWhitelabel(Whitelabel $whitelabel)
    {
        $admins = Role::where('name', Flag::ADMINISTRATOR_ROLE)->first()->users()->get();

        foreach ($admins as $admin) {
            createNotification(Lang::get('notification.restored', ['name' => 'Whitelabel', 'url' => $whitelabel->display_name, 'user' =>  Auth::guard('web')->user()->first_name . ' ' . Auth::guard('web')->user()->last_name]), $admin->id, Auth::guard('web')->user()->id);
        }

        Notification::send($admins, new RestoredWhitelabelNotification($whitelabel));
    }
}
