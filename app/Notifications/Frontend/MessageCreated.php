<?php

namespace App\Notifications\Frontend;

use App\Models\Messages\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

/**
 * Class MessageCreated.
 */
class MessageCreated extends Notification
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
    protected $type;

    /**
     * @var
     */
    protected $message;

    /**
     * @var
     */
    protected $wl_name;

    /**
     * UserContactedSeller constructor.
     *
     * @param $wish_id
     * @param $token
     * @param $type
     */
    public function __construct($wish_id, $type, $token, Message $message)
    {
        $this->wish_id = $wish_id;
        $this->token = $token;
        $this->type = $type;
        $this->message = $message;
        $this->wl_name = \App\Models\Whitelabels\Whitelabel::find($message->wish->whitelabel->id)->name;
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
        $subject = trans('email.message.created-' . $this->type, ['whitelabel' => $this->wl_name]);
        $view = 'emails.messages.created-' . $this->type;

        return (new MailMessage())
            ->from($this->message->wish->whitelabel->email, $this->wl_name . ' Portal')
            ->subject($subject)
            ->view($view, [
                    'confirmation_url'      => $confirmation_url,
                    'whitelabelId'      => $this->message->wish->whitelabel->id,
                    'messageModel'          => $this->message,
                    'whitelabel'        => $this->message->wish->whitelabel
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

        return $whitelabelId->domain . '/wishes/' . $this->wish_id . '/' . $this->token;
    }
}
