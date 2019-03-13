<?php

namespace App\Notifications\Frontend;

use App\Models\Offers\Offer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

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

    /**
     * UserContactedSeller constructor.
     *
     * @param $wish_id
     * @param $token
     * @param Offer $offer
     */
    public function __construct($wish_id, $token, Offer $offer)
    {
        $this->wish_id = $wish_id;
        $this->token = $token;
        $this->offer = $offer;
        $this->wl_name = \App\Models\Whitelabels\Whitelabel::find($offer->wish->whitelabel->id)->name;
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
        $confirmation_url = route($this->getRoute(), [$this->wish_id, $this->token]);
        $subject = trans('email.offer.created');
        $view = 'emails.offer.offer-created';

        return (new MailMessage())
            ->from('noreply@desiretec.com', $this->wl_name.' Portal')
            ->subject($subject)
            ->view($view, [
                    'confirmation_url' => $confirmation_url,
                    'offer'          => $this->offer
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
            $whitelabelslug = strtolower($this->wl_name);

            return $whitelabelslug . '.wish.details';
        }

        return 'frontend.wishes.details';
    }
}
