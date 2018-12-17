<?php

namespace Modules\Groups\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
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
    }
}
