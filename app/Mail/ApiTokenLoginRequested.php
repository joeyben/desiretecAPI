<?php

namespace App\Mail;

use App\Models\Access\User\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApiTokenLoginRequested extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $user;
    public $options;

    private $whiteLabel;

    public function __construct(User $user, array $options)
    {
        $this->user = $user;
        $this->whiteLabel = $user->whitelabels()->find($options['whitelabelId']);
        $this->options = $options;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if (null === $this->whiteLabel) {
            $subject = trans('email.message.token_new', [
                'whitelabel' => config('mail.from.whitelabel'),
            ]);
            $formAddress = config('mail.from.email');
            $formName = config('mail.from.name');
        } else {
            $subject = trans('email.message.token_new', [
                'whitelabel' => $this->whiteLabel->display_name,
            ]);
            $formAddress = $this->whiteLabel->email;
            $formName = $this->whiteLabel->display_name;
        }

        return $this->subject($subject)
            ->from($formAddress, $formName . ' Reisewunschportal')
            ->view('emails.token.link')->with([
                'link'             => $this->buildLink(),
                'whitelabel_name'  => $formName,
                'whitelabel'       => $this->whiteLabel,
                'whitelabelId'     => $this->whiteLabel->id
            ]);
    }

    protected function buildLink()
    {
        return $this->options['host'] . '/api/token?' . http_build_query(array_merge(['token' => $this->user->token->token], $this->options));
    }
}
