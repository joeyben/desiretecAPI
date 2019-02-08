<?php

namespace Modules\Whitelabels\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Modules\Whitelabels\Entities\Whitelabel;

class CreateWhitelabelNotification extends Notification implements ShouldBroadcast
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
     * @var string
     */
    private $step;

    /**
     * Create a new notification instance.
     *
     * @param \Modules\Whitelabels\Entities\Whitelabel $whitelabel
     * @param string                                   $step
     */
    public function __construct(Whitelabel $whitelabel, string $step = 'Step 1')
    {
        $this->whitelabel = $whitelabel;
        $this->url = route('admin.whitelabels') . '#/edit/' . $this->whitelabel->id;
        $this->step = $step;
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
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->subject('[' . config('app.name', 'MVP') . '] ' . $this->whitelabel->display_name)
            ->view('whitelabels::emails.created', ['whitelabel' => $this->whitelabel]);
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

    /**
     * @param $notifiable
     *
     * @return \Illuminate\Notifications\Messages\BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        createNotification('<span class="badge badge-flat border-success text-success-600 rounded-0 mr-2">' . $this->step . ' :</span> Create whitelabel <a  href="' . $this->url . '"> ' . $this->whitelabel->display_name . '</a> has been <strong>successfully created</strong>' . $this->whitelabel->display_name, $notifiable->id);

        return new BroadcastMessage([
            'id'         => $this->whitelabel->id,
            'message'    => '<span class="badge badge-flat border-success text-success-600 rounded-0 mr-2">' . $this->step . ' :</span> Create whitelabel <a  href="' . $this->url . '"> ' . $this->whitelabel->display_name . '</a> has been <strong>successfully created</strong>',
            'user_id'    => $notifiable->id,
        ]);
    }
}
