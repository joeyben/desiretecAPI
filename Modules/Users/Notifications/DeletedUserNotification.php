<?php

namespace Modules\Users\Notifications;

use App\Models\Access\User\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class DeletedUserNotification extends Notification implements ShouldBroadcast
{
    use Queueable;
    /**
     * @var \App\Models\Access\User\User
     */
    private $user;

    /**
     * Create a new notification instance.
     *
     * @param \App\Models\Access\User\User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->url = 'javascript:;';
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
        return ['broadcast'];
    }

    public function toBroadcast($notifiable)
    {
        createNotification(Lang::get('notification.deleted', ['name' => 'User', 'url' => '<a  href="' . $this->url . '"> ' . $this->user->first_name . '</a>', 'user' => Auth::guard('web')->user()->first_name . ' ' . Auth::guard('web')->user()->last_name]), $notifiable->id, Auth::guard('web')->user()->id);

        return new BroadcastMessage([
            'id'      => $this->user->id,
            'message' => Lang::get('notification.deleted', ['name' => 'User', 'url' => '<a  href="' . $this->url . '"> ' . $this->user->first_name . '</a>', 'user' => Auth::guard('web')->user()->first_name . ' ' . Auth::guard('web')->user()->last_name]),
            'user_id' => $notifiable->id,
            'from_id' => Auth::guard('web')->user()->id,
            'from'    => [
                'id'        => Auth::guard('web')->user()->id,
                'full_name' => Auth::guard('web')->user()->first_name . ' ' . Auth::guard('web')->user()->last_name
            ],
            'created_at' => Carbon::parse(now())->format('c'),
        ]);
    }
}
