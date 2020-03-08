<?php

namespace App\Notifications\Frontend;

use App\Models\Offers\Offer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

/**
 * Class OfferCreated.
 */
class OfferCreated extends Notification
{
    use Queueable;

    /**
     * @var
     */
    protected $wish_id;

    /**
     * @var
     */
    protected $token;

    /**
     * @var
     */
    protected $offer;

    /**
     * @var
     */
    protected $wl_name;

    protected $wl_id;

    /**
     * UserContactedSeller constructor.
     *
     * @param $wish_id
     * @param $token
     */
    public function __construct($wish_id, $token, Offer $offer)
    {
        $this->wish_id = $wish_id;
        $this->token = $token;
        $this->offer = $offer;
        $this->wl_name = \App\Models\Whitelabels\Whitelabel::find($offer->wish->whitelabel->id)->name;
        $this->wl_id = \App\Models\Whitelabels\Whitelabel::find($offer->wish->whitelabel->id)->id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param \App\Models\Access\User\User $user
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail()
    {
        $confirmation_url = url($this->getRoute());
        $subject = trans('email.offer.created');
        $view = 'emails.offer.offer-created';

        return (new MailMessage())
            ->from($this->offer->wish->whitelabel->email, $this->wl_name . ' Portal')
            ->subject($subject)
            ->view($view, [
                    'confirmation_url' => $confirmation_url,
                    'offer'            => $this->offer,
                    'offer_type'       => 'manual',
                    'whitelabelId'     =>  $this->wl_id,
                    'whitelabel'       => $this->offer->wish->whitelabel
                ]);
    }

    /**
     * Get url from whitelabel.
     *
     * @param mixed $notifiable
     *
     * @return string
     */
    public function getRoute()
    {
        if (isWhiteLabel()) {
            $whitelabelslug = mb_strtolower($this->wl_name);

            return $whitelabelslug . '.wish.details';
        }

        $whitelabelId = Auth::guard('api')->user()->whitelabels()->first();
        $route = $whitelabelId->name . '.wish.details';

        if (\Route::has($route, [$this->wish_id, $this->token])) {
            return route($route, [$this->wish_id, $this->token]);
        }

        return $whitelabelId->domain . '/wishes/' . $this->wish_id;
    }
}
