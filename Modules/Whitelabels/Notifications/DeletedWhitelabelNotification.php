<?php

namespace Modules\Whitelabels\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Modules\Whitelabels\Entities\Whitelabel;

class DeletedWhitelabelNotification extends Notification implements ShouldBroadcast
{
    use Queueable;
    /**
     * @var \Modules\Whitelabels\Entities\Whitelabel
     */
    private $whitelabel;
    /**
     * @var string
     */
    private $url;

    /**
     * Create a new notification instance.
     */
    public function __construct(Whitelabel $whitelabel)
    {
        $this->whitelabel = $whitelabel;
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

    /**
     * @param $notifiable
     *
     * @return \Illuminate\Notifications\Messages\BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        createNotification(Lang::get('notification.deleted', ['name' => ' Whitelabel', 'url' => '<a  href="' . $this->url . '"> ' . $this->whitelabel->display_name . '</a>', 'user' =>  Auth::guard('web')->user()->first_name . ' ' . Auth::guard('web')->user()->last_name]), $notifiable->id, Auth::guard('web')->user()->id);

        return new BroadcastMessage([
            'id'         => $this->whitelabel->id,
            'message'    => Lang::get('notification.deleted', ['name' => ' Whitelabel', 'url' =>'<a  href="' . $this->url . '"> ' . $this->whitelabel->display_name . '</a>', 'user' =>  Auth::guard('web')->user()->first_name . ' ' . Auth::guard('web')->user()->last_name]),
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
