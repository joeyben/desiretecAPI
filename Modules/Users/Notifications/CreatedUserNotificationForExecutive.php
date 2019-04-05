<?php

namespace Modules\Users\Notifications;

use App\Models\Access\User\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class CreatedUserNotificationForExecutive extends Notification
{
    use Queueable;
    /**
     * @var \App\Models\Access\User\User
     */
    private $user;
    /**
     * @var string
     */
    private $password;

    /**
     * Create a new notification instance.
     *
     * @param \App\Models\Access\User\User $user
     * @param string                       $password
     */
    public function __construct(User $user, string $password)
    {
        $this->user = $user;
        $this->password = $password;
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
            ->subject(Lang::get('email.account.subject_for_executive'))
            ->view('users::emails.created_executive', ['user' => $this->user, 'password' => $this->password, 'whitelabel' => $this->user->whitelabels()->first()])
            ->replyTo(env('MAIL_REPLY', 'reply@desiretec.com'), 'Desiretec');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
        ];
    }
}