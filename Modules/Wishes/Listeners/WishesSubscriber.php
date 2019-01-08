<?php

namespace Modules\Wishes\Listeners;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Modules\Groups\Entities\Group;
use Modules\Wishes\Entities\Wish;
use Modules\Wishes\Notifications\CreatedWishNotification;
use App\Models\Access\User\User;
use App\Models\Access\User\Traits\TokenAuthenticable;
use Illuminate\Http\Request;

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

    use TokenAuthenticable;

    public function onCreatedWish(Wish $wish)
    {
        $user = User::where('id', $wish->created_by)->firstOrFail();
      
        $usertoken = $user->storeToken();
    
        $token = $usertoken->token->token;
        $wish['token'] = $token;
        
        $users = Group::find($wish->group_id)->users()->get();
        Auth::guard('web')->user()->notify(new CreatedWishNotification($wish));
        Notification::send($users, new CreatedWishNotification($wish));
    }
}
