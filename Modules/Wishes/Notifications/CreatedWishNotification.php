<?php

namespace Modules\Wishes\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Lang;
use Modules\Wishes\Entities\Wish;

class CreatedWishNotification extends Notification
{
    use Queueable;
    /**
     * @var \Modules\Wishes\Entities\Wish
     */
    private $wish;

    /**
     * Create a new notification instance.
     *
     * @param \Modules\Wishes\Entities\Wish $wish
     */
    public function __construct(Wish $wish)
    {
        $this->wish = $wish;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
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
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)->view('wishes::emails.wish', ['wish' => $this->wish])->replyTo(env('MAIL_REPLY', 'reply@desiretec.com'), 'Desiretec');
    }
}
