<?php

namespace Modules\Wishes\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;
use Modules\Wishes\Entities\Wish;
use Spatie\Newsletter\NewsletterFacade;

class CreatedWishNotificationForSeller extends Notification
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
        $wish->load('owner');
        $this->wish = $wish;
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
        $notifiable->storeToken();
        createNotification(Lang::get('notification.created', ['name' => 'Wish', 'url' =>  $this->wish->title, 'user' => Auth::guard('web')->user()->first_name . ' ' . Auth::guard('web')->user()->last_name]), $notifiable->id, $this->wish->created_by);

        if ('Trendtours' === $this->wish->whitelabel->name) {
            Log::info($this->wish->toJson());

            NewsletterFacade::subscribe($this->wish->owner->email,
                [
                    'ZIEL' => 'ZIEL',
                    'START' => 'START',
                    'ZEITRAUM' => 'ZEITRAUM',
                    'PAXE' => 'PAXE',
                    'TEXT' => 'TEXT',
                ]);

            return (new MailMessage())
                ->from('trendtours@reisewunschservice.de', $this->wish->whitelabel->display_name . ' Portal')
                ->subject(trans('email.wish.seller_trendtours'))
                ->view('wishes::emails.wish_seller_trendtours', ['wish' => $this->wish, 'token' => $notifiable->token->token, 'user' => $notifiable]);
        }

        return (new MailMessage())
            ->from($this->wish->whitelabel->email, $this->wish->whitelabel->display_name . ' Portal')
            ->subject(trans('email.wish.seller'))
            ->view('wishes::emails.wish_seller', ['wish' => $this->wish, 'token' => $notifiable->token->token, 'user' => $notifiable]);
    }
}
