<?php

namespace App\Listeners\Frontend;

use App\Models\Contact\Contact;
use App\Models\Groups\Group;
use App\Notifications\Frontend\UserContactedSeller;

/**
 * Class ContactEventListener.
 */
class ContactEventListener
{
    /**
     * @var \App\Models\Contact\Contact
     */
    private $contact;

    /**
     * Create the event listener.
     *
     * @param Contact $contact
     */
    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    /**
     * @param $events
     */
    public function subscribe($events)
    {
        $events->listen('eloquent.created: App\Models\Contact\Contact', [$this, 'onCreatedContact']);
    }

    public function onCreatedContact(Contact $contact)
    {
        $group = Group::where('id', $contact->group_id)->firstOrFail();
        $user = $group->users[0];

        $usertoken = $user->storeToken();

        $token = $usertoken->token->token;

        $user->notify(new UserContactedSeller($contact->wish_id, $token, $contact));
    }
}
