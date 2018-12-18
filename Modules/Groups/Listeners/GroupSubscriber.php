<?php

namespace Modules\Groups\Listeners;

use App\Models\Access\Role\Role;
use Modules\Groups\Entities\Group;

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
    }

    public function onCreatedGroup(Group $group)
    {
        $admins = Role::where('name', 'Administrator')->first()->users()->get();
        $owner = $group->owner()->first();

        foreach ($admins as $admin) {
            createNotification('Group: ' . $group->name . ' has been successfully created by: ' . $owner->first_name . ' ' . $owner->last_name, $admin->id);
        }
        createNotification('Group: ' . $group->name . '  has been successfully created by: ' . $owner->first_name . ' ' . $owner->last_name, $owner->id);
    }
}
