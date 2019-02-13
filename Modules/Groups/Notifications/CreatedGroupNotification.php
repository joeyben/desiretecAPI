<?php

namespace Modules\Groups\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Auth;
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
     *
     * @param \Modules\Groups\Entities\Group $group
     * @param string                         $owner
     */
    public function __construct(Group $group, string $owner)
    {
        $this->group = $group;
        $this->url = route('provider.groups') . '#/edit/' . $this->group->id;
        $this->owner = $owner;
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
     * @param $notifiable
     *
     * @return \Illuminate\Notifications\Messages\BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        createNotification('<span class="badge badge-flat border-success text-success-600 rounded-0 mr-2"> Created</span><strong>Group</strong>(<a  href="' . $this->url . '">' . $this->group->display_name . '</a>) has been <strong>successfully created</strong> by: <strong class="cursor-pointer">' .  $this->owner . '</strong>', $notifiable->id, Auth::guard('web')->user()->id);

        return new BroadcastMessage([
            'id' => $this->group->id,
            'message' => '<span class="badge badge-flat border-success text-success-600 rounded-0 mr-2"> Created</span><strong>Group</strong>(<a  href="' . $this->url . '">' . $this->group->display_name . '</a>) has been <strong>successfully created</strong> by: <strong class="cursor-pointer">' . $this->owner . '</strong>',
            'user_id' => $notifiable->id,
            'from_id' => Auth::guard('web')->user()->id,
            'from'    => [
                'id' => Auth::guard('web')->user()->id,
                'full_name' => Auth::guard('web')->user()->first_name . ' ' . Auth::guard('web')->user()->last_name
            ],
            'created_at' => Carbon::parse(now())->format('c'),
        ]);
    }
}
