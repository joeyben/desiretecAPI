<?php

namespace App\Listeners\Frontend;

use App\Models\Access\User\User;
use App\Models\Offers\Offer;
use App\Notifications\Frontend\OfferCreated;
use App\Notifications\Frontend\OfferUser;
use Illuminate\Support\Facades\Auth;

/**
 * Class OfferEventListener.
 */
class OfferEventListener
{
    /**
     * @var \App\Models\Offers\Offer
     */
    private $offer;

    /**
     * Create the event listener.
     *
     * @param Offer $contact
     */
    public function __construct(Offer $offer)
    {
        $this->offer = $offer;
    }

    /**
     * @param $events
     */
    public function subscribe($events)
    {
        $events->listen('eloquent.created: App\Models\Offers\Offer', [$this, 'onCreatedOffer']);
    }

    public function onCreatedOffer(Offer $offer)
    {
        $user_id = $offer->wish->owner->id;
        $user = User::where('id', (int) $user_id)->firstOrFail();
        $usertoken = $user->storeToken();
        $token = $usertoken->token->token;

        $seller = Auth::guard('web')->user();
        $sellertoken = $seller->storeToken();
        $token_seller = $sellertoken->token->token;

        $seller->notify(new OfferCreated($offer->wish_id, $token_seller, $offer));
        $user->notify(new OfferUser($offer->wish_id, $token, $offer));
    }
}
