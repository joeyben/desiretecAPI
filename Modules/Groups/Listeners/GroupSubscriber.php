<?php

namespace Modules\Groups\Listeners;

use App\Models\Access\Role\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Modules\Groups\Entities\Group;
use Modules\Groups\Notifications\CreatedGroupNotification;
use Modules\Groups\Notifications\DeletedGroupNotification;

class GroupSubscriber
{
    /**
     * @var \Modules\Groups\Entities\Group
     */
    private $group;

    /**
     * Create the event listener.
     *
     * @param \Modules\Groups\Entities\Group $group
     */
    public function __construct(Group $group)
    {
        $this->group = $group;
    }

    /**
     * @param $events
     */
    public function subscribe($events)
    {
        $events->listen('eloquent.created: Modules\Groups\Entities\Group', [$this, 'onCreatedGroup']);
        $events->listen('eloquent.deleted: Modules\Groups\Entities\Group', [$this, 'onDeletedGroup']);
        $events->listen('eloquent.restored: Modules\Groups\Entities\Group', [$this, 'onRestoredGroup']);
    }

    public function onCreatedGroup(Group $group)
    {
        $admins = Role::where('name', 'Administrator')->first()->users()->where('users.id', '!=', Auth::guard('web')->user()->id)->get();

        Notification::send($admins, new CreatedGroupNotification($group, Auth::guard('web')->user()->first_name . ' ' . Auth::guard('web')->user()->last_name));
        Auth::guard('web')->user()->notify(new CreatedGroupNotification($group, Auth::guard('web')->user()->first_name . ' ' . Auth::guard('web')->user()->last_name));
    }

    public function onDeletedGroup(Group $group)
    {
        $admins = Role::where('name', 'Administrator')->first()->users()->where('users.id', '!=', Auth::guard('web')->user()->id)->get();
        $owner = $group->owner()->first();

        Notification::send($admins, new DeletedGroupNotification($group, Auth::guard('web')->user()->first_name . ' ' . Auth::guard('web')->user()->last_name));
        Notification::send($owner, new DeletedGroupNotification($group, Auth::guard('web')->user()->first_name . ' ' . Auth::guard('web')->user()->last_name));
        Auth::guard('web')->user()->notify(new DeletedGroupNotification($group, Auth::guard('web')->user()->first_name . ' ' . Auth::guard('web')->user()->last_name));
    }

    public function onRestoredGroup(Group $group)
    {
        $admins = Role::where('name', 'Administrator')->first()->users()->where('users.id', '!=', Auth::guard('web')->user()->id)->get();
        $owner = $group->owner()->first();

        foreach ($admins as $admin) {
            createNotification('<span class="badge badge-flat border-info text-info-600 rounded-0 mr-2"> Restored </span>  <strong> Group (</strong>' . $group->display_name . '<strong>)</strong> has been <strong>successfully restored</strong> by: <u class="text-primary-800 cursor-pointer">' . Auth::guard('web')->user()->first_name . ' ' . Auth::guard('web')->user()->last_name . '</u>', $admin->id);
        }
        createNotification('<span class="badge badge-flat border-info text-info-600 rounded-0 mr-2"> Restored </span>  <strong> Group (</strong>' . $group->display_name . '<strong>)</strong> has been <strong>successfully restored</strong> by: <u class="text-primary-800 cursor-pointer">' . Auth::guard('web')->user()->first_name . ' ' . Auth::guard('web')->user()->last_name . '</u>', $owner->id);

        if ((int) $owner->id !== (int) Auth::guard('web')->user()->id) {
            createNotification('<span class="badge badge-flat border-info text-info-600 rounded-0 mr-2"> Restored </span>  <strong> Group (</strong>' . $group->display_name . '<strong>)</strong> has been <strong>successfully restored</strong> by: <u class="text-primary-800 cursor-pointer">' . Auth::guard('web')->user()->first_name . ' ' . Auth::guard('web')->user()->last_name . '</u>', Auth::guard('web')->user()->id);
        }
    }
}
