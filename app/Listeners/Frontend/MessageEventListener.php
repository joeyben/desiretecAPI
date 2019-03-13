<?php

namespace App\Listeners\Frontend;

use App\Models\Messages\Message;
use App\Models\Access\User\User;
use App\Notifications\Frontend\MessageCreated;
use Illuminate\Support\Facades\Auth;

/**
 * Class MessageEventListener.
 */
class MessageEventListener
{
    /**
     * @var \App\Models\Messages\Message
     */
    private $message;

    /**
     * Create the event listener.
     *
     * @param Message $contact
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * @param $events
     */
    public function subscribe($events)
    {
        $events->listen('eloquent.created: App\Models\Messages\Message', [$this, 'onCreatedMessage']);
    }

    public function onCreatedMessage(Message $message)
    {
        $user_id = Auth::guard('web')->user()->id === $message->wish->owner->id ?
            $message->wish->group->users[0]->id : $message->wish->owner->id;

        $user = User::where('id', intval($user_id))->firstOrFail();
        $usertoken = $user->storeToken();
        $token = $usertoken->token->token;
        $role = $user->hasRole('Seller') ? 'seller' : 'user';

        $user->notify(new MessageCreated($message->wish_id, $role, $token, $message));
    }
}
