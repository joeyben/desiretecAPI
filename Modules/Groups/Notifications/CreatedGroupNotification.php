<?php

namespace Modules\Groups\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Modules\Groups\Entities\Group;

class CreatedGroupNotification extends Notification implements ShouldBroadcast
{
    use Queueable;
    /**
     * @var \Modules\Groups\Entities\Group
     */
    private $group;
    /**
     * @var string
     */
    private $url;
    /**
     * @var string
     */
    private $owner;

    /**
     * Create a new notification instance.
     */
    public function __construct(Group $group, string $owner)
    {
        $this->group = $group;
        $this->url = route('admin.groups') . '#/edit/' . $this->group->id;
        $this->owner = $owner;
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

    /**
     * @param $notifiable
     *
     * @return \Illuminate\Notifications\Messages\BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        createNotification(Lang::get('notification.created', ['name' => 'Group', 'url' => '<a  href="' . $this->url . '"> ' . $this->group->display_name . '</a>', 'user' => $this->owner]), $notifiable->id, Auth::guard('web')->user()->id);

        return new BroadcastMessage([
            'id'      => $this->group->id,
            'message' => Lang::get('notification.created', ['name' => 'Group', 'url' => '<a  href="' . $this->url . '"> ' . $this->group->display_name . '</a>', 'user' => $this->owner]),
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
