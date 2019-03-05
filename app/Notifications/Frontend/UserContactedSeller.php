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
     * UserContactedSeller constructor.
     *
     * @param $wish_id
     * @param $token
     * @param Contact $contact
     */
    public function __construct($wish_id, $token, Contact $contact)
    {
        $this->wish_id = $wish_id;
        $this->token = $token;
        $this->contact = $contact;
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

        return (new MailMessage())
            ->view('emails.user-contact-seller', [
                    'confirmation_url' => $confirmation_url,
                    'contact'          => $this->contact
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
            $whitelabelslug = \App\Models\Whitelabels\Whitelabel::find(getCurrentWhiteLabelId())->name;

            return $whitelabelslug . '.wish.details';
        }

        return 'frontend.wishes.wish';
    }
}
