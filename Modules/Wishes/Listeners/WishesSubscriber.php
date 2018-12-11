<?php

namespace Modules\Wishes\Listeners;

use App\Models\Access\User\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Modules\Groups\Entities\Group;
use Modules\Wishes\Entities\Wish;
use Modules\Wishes\Notifications\CreatedWishNotification;

class WishesSubscriber
{
    /**
     * @var \Modules\Wishes\Entities\Wish
     */
    private $wish;

    /**
     * Create the event listener.
     *
     * @param \Modules\Wishes\Entities\Wish $wish
     */
    public function __construct(Wish $wish)
    {
        $this->wish = $wish;
    }

    /**
     * @param $events
     */
    public function subscribe($events)
    {
        $events->listen('eloquent.created: Modules\Wishes\Entities\Wish', [$this, 'onCreatedWish']);
    }

    public function onCreatedWish(Wish $wish)
    {
        $users = Group::find($wish->group_id)->users()->get();
        Auth::guard('web')->user()->notify(new CreatedWishNotification($wish));
        Notification::send($users, new CreatedWishNotification($wish));
    }
}
