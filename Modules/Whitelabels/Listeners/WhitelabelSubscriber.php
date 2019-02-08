<?php

namespace Modules\Whitelabels\Listeners;

use App\Models\Access\User\User;
use App\Services\Flag\Src\Flag;
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
    }

    public function onCreatedWhitelabel(Whitelabel $whitelabel)
    {
        $users = User::whereHas('roles', function ($query) {
            $query->where('roles.name', Flag::ADMINISTRATOR_ROLE);
        })->get();

        Notification::send($users, new CreateWhitelabelNotification($whitelabel));
    }
}
