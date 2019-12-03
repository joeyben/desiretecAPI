<?php

namespace Modules\Wishes\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Modules\Wishes\Entities\Wish;

class AutoOfferNotification extends Notification
{
    use Queueable;

    /**
     * @var \Modules\Wishes\Entities\Wish
     */
    private $wish;
    //private $token;

    /**
     * Create a new notification instance.
     *
     * @param \Modules\Wishes\Entities\Wish $wish
     */
    public function __construct(Wish $wish)
    {
        $this->wish = $wish;
        //$this->$token = $token;
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
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        createNotification(Lang::get('notification.created', ['name' => 'Wish', 'url' =>  $this->wish->title, 'user' => Auth::guard('web')->user()->first_name . ' ' . Auth::guard('web')->user()->last_name]), $notifiable->id, $this->wish->created_by);

        /**if ('Novasol' === $this->wish->whitelabel->name) {
            return (new MailMessage())
            ->from($this->wish->whitelabel->email, $this->wish->whitelabel->display_name . ' Portal')
            ->subject(trans('email.offer.novasol_created_user.subject'))
            ->view('wishes::emails.offer_novasol', ['wish' => $this->wish, 'token' => $this->wish->token]);
        }*/
    }
}
