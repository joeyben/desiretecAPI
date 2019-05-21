<?php

namespace Modules\LanguageLines\Notifications;

use App\Models\Access\User\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class CopyLanguageLinesNotification extends Notification
{
    use Queueable;
    /**
     * @var string
     */
    private $url;
    /**
     * @var string
     */
    private $count;

    /**
     * Create a new notification instance.
     *
     * @param string $count
     */
    public function __construct(string $count)
    {
        $this->url = 'javascript:;';
        $this->count = $count;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        createNotification('Languages has been successfully copyed: ' . $this->count . ' by <strong>' . Auth::guard('web')->user()->first_name . ' ' . Auth::guard('web')->user()->last_name . '</strong>', $notifiable->id, Auth::guard('web')->user()->id);

        return new BroadcastMessage([
            'id'         => 0,
            'message'    => Lang::get('notification.updated', ['name' => ' Language', 'url' =>'-', 'user' =>  Auth::guard('web')->user()->first_name . ' ' . Auth::guard('web')->user()->last_name]),
            'user_id'    => $notifiable->id,
            'from_id'    => Auth::guard('web')->user()->id,
            'from'       => [
                'id'        => Auth::guard('web')->user()->id,
                'full_name' => Auth::guard('web')->user()->first_name . ' ' . Auth::guard('web')->user()->last_name
            ],
            'created_at' => Carbon::parse(now())->format('c'),
        ]);
    }
}
