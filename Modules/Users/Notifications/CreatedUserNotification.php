<?php

namespace Modules\Users\Notifications;

use App\Models\Access\User\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class CreatedUserNotification extends Notification implements ShouldBroadcast
{
    use Queueable;
    /**
     * @var \App\Models\Access\User\User
     */
    private $user;
    /**
     * @var string
     */
    private $url;

    /**
     * Create a new notification instance.
     *
     * @param \App\Models\Access\User\User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->url = route('admin.sellers') . '#/seller/' . $this->user->id;
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
        createNotification('<span class="badge badge-flat border-success text-success-600 rounded-0 mr-2"> Created</span><strong>User</strong>(<a  href="' . $this->url . '">' . $this->user->first_name . '</a>) has been <strong>successfully created</strong> by: <strong class="cursor-pointer">' . Auth::guard('web')->user()->first_name . ' ' . Auth::guard('web')->user()->last_name . '</strong>', $notifiable->id, Auth::guard('web')->user()->id);

        return new BroadcastMessage([
            'id'      => $this->user->id,
            'message' => '<span class="badge badge-flat border-success text-success-600 rounded-0 mr-2"> Created</span><strong>User</strong>(<a  href="' . $this->url . '">' . $this->user->first_name . '</a>) has been <strong>successfully created</strong> by: <strong class="cursor-pointer">' . Auth::guard('web')->user()->first_name . ' ' . Auth::guard('web')->user()->last_name . '</strong>',
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
