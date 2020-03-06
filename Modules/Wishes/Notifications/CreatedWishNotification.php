<?php

namespace Modules\Wishes\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Modules\Wishes\Entities\Wish;

class CreatedWishNotification extends Notification
{
    use Queueable;

    /**
     * @var \Modules\Wishes\Entities\Wish
     */
    private $wish;
    //private $token;

    private $_whitelabels = [];

    /**
     * Create a new notification instance.
     */
    public function __construct(Wish $wish)
    {
        $this->wish = $wish;
        $this->_setWhitelabelData();
        //$this->$token = $token;
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
        if ('Trendtours' === $this->wish->whitelabel->name) {
            return [];
        }

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
        createNotification(Lang::get('notification.created', ['name' => 'Wish', 'url' =>  $this->wish->title, 'user' => Auth::guard('web')->user()->first_name . ' ' . Auth::guard('web')->user()->last_name]), $notifiable->id, $this->wish->created_by);

        return (new MailMessage())
            ->from($this->wish->whitelabel->email, $this->wish->whitelabel->display_name . ' Reisewunschportal')
            ->replyTo($this->wish->whitelabel->email, $this->wish->whitelabel->display_name . ' Reisewunschportal')
            ->subject(trans('email.wish.user', ['whitelabel' => $this->wish->whitelabel->display_name]))
            //->view('wishes::emails.wish_general', ['wish' => $this->wish, 'token' => $this->wish->token]);
            ->view('wishes::emails.wish', ['wish' => $this->wish, 'whitelabelId' => $this->wish->whitelabel->id, 'token' => $this->wish->token]);

        /*
                $whitelabelData = $this->_getWhitelabelData();

                error_log(print_r($whitelabelData, true));


                if(!is_null($whitelabelData)){
                    error_log('from => '. $whitelabelData['from']);
                    error_log('to => '. $whitelabelData['replayTo']);

                    return (new MailMessage())
                        ->from($whitelabelData['from'], $this->wish->whitelabel->display_name . ' Portal')
                        ->replyTo($whitelabelData['replyTo'], $this->wish->whitelabel->display_name . ' Portal')
                        ->subject(trans('email.wish.user', ['whitelabel' => $this->wish->whitelabel->display_name]))
                        ->view('wishes::emails.wish_general', ['wish' => $this->wish, 'token' => $this->wish->token]);
                }
        */

//        if ('Trendtours' === $this->wish->whitelabel->name) {
//            return (new MailMessage())
//                ->from('trendtours@reisewunschservice.de', $this->wish->whitelabel->display_name . ' Portal')
//                ->replyTo('wunschreise@trendtours.de', $this->wish->whitelabel->display_name . ' Portal')
//                ->subject()
//                ->view('wishes::emails.wish_trendtours', ['wish' => $this->wish, 'token' => $this->wish->token]);
//        }

//        if ('Novasol' === $this->wish->whitelabel->name) {
//            return (new MailMessage())
//                ->from('novasol@reisewunschservice.de', $this->wish->whitelabel->display_name . ' Portal')
//                ->replyTo('wunschreise@novasol.de', $this->wish->whitelabel->display_name . ' Portal')
//                ->subject(trans('email.wish.user_novasol'))
//                ->view('wishes::emails.wish_novasol', ['wish' => $this->wish, 'token' => $this->wish->token]);
//        }
    }

    /* Private functions -------------------------------------------------------------------------------------------------*/

    /**
     * Sets the whitelabels-data.
     */
    private function _setWhitelabelData()
    {
        $this->_whitelabels = [
            'trendtours' => [
                'from'     => 'trendtours@reisewunschservice.de', // optional :)
                'replayTo' => 'wunschreise@trendtours.de',    // required!
            ],
            'novasol' => [
                'from'     => 'novasol@reisewunschservice.de', // optional :)
                'replayTo' => 'wunschreise@novasol.de',    // required!
            ],
            'lastminute' => [
                'from'     => '',                              // optional :)
                'replayTo' => 'wunschreise@trendtours.de', // required!
            ]
        ];
    }

    /**
     * Returns the active whitelabel-data.
     */
    private function _getWhitelabelData()
    {
        $activeWhitelabel = null;
        $activeWhitelabelName = mb_strtolower($this->wish->whitelabel->name);

        if (\array_key_exists($activeWhitelabelName, $this->_whitelabels)) {
            $activeWhitelabel = $this->_whitelabels[$activeWhitelabelName];
            if (empty($activeWhitelabel['from']) or !isset($activeWhitelabel['from'])) {
                // A 'From' email is generated because none could be found.
                $activeWhitelabel['from'] = $activeWhitelabelName . '@reisewunschservice.de';
            }
        }

        return $activeWhitelabel;
    }
}
