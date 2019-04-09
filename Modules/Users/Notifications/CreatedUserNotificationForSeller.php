<?php

namespace Modules\Users\Notifications;

use App\Models\Access\User\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class CreatedUserNotificationForSeller extends Notification
{
    use Queueable;
    /**
     * @var string
     */
    private $password;
    /**
     * @var \App\Models\Access\User\User
     */
    private $user;
    private $whitelabel;

    /**
     * Create a new notification instance.
     *
     * @param \App\Models\Access\User\User $user
     * @param string                       $password
     * @param                              $whitelabel
     */
    public function __construct(User $user, string $password, $whitelabel)
    {
        $this->user = $user;
        $this->password = $password;
        $this->whitelabel = $whitelabel;
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
        return (new MailMessage())
            ->subject(Lang::get('email.account.subject_for_seller', ['whitelabel' => $this->whitelabel]))
            ->view('users::emails.created_seller', ['user' => $this->user, 'password' => $this->password, 'whitelabel' => $this->whitelabel])
            ->replyTo(env('MAIL_REPLY', 'reply@desiretec.com'), 'Desiretec');
    }
}
