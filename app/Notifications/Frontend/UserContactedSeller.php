<?php

namespace App\Notifications\Frontend;

use App\Models\Contact\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Class UserContactedSeller.
 */
class UserContactedSeller extends Notification
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
    protected $contact;

    /**
     * @var
     */
    protected $wl_name;

    /**
     * UserContactedSeller constructor.
     *
     * @param $wish_id
     * @param $token
     */
    public function __construct($wish_id, $token, Contact $contact)
    {
        $this->wish_id = $wish_id;
        $this->token = $token;
        $this->contact = $contact;
        $this->wl_name = \App\Models\Whitelabels\Whitelabel::find($contact->wish->whitelabel->id)->name;
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
        $confirmation_url = env('APP_USE_API') ?
            'https://'.strtolower($this->contact->wish->whitelabel->name).'.wish-service.com/wish/'.$this->contact->wish->id.'/'.$this->token :
            route($this->getRoute(), [$this->wish_id, $this->token]);

        $subject = ('no data' !== $this->contact->email) ? trans('email.wish.user_cnt_seller')
                : trans('email.wish.user_callback_seller');
        $view = ('no data' !== $this->contact->email) ? 'emails.user-contact-seller' : 'emails.user-callback-seller';

        return (new MailMessage())
            ->from($this->contact->wish->whitelabel->email, $this->wl_name . ' Portal')
            ->subject($subject)
            ->view($view, [
                    'confirmation_url' => $confirmation_url,
                    'contact'          => $this->contact,
                    'wish_id'          => $this->wish_id,
                    'token'            => $this->token,
                    'whitelabelId'     => $this->contact->wish->whitelabel->id,
                    'whitelabel_name'  => $this->contact->wish->whitelabel->name,
                    'whitelabel'       => $this->contact->wish->whitelabel
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

        return 'frontend.wishes.details';
    }
}
