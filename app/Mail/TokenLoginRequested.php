<?php

namespace App\Mail;

use App\Models\Access\User\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TokenLoginRequested extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $user;
    public $options;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, array $options)
    {
        $this->user = $user;
        $this->options = $options;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = trans('email.message.token_new', [
            'whitelabel' => getCurrentWhiteLabelField('display_name')
        ]);

        return $this->subject($subject)
            ->from(getCurrentWhiteLabelField('email'), getCurrentWhiteLabelField('display_name') . ' Portal')
            ->view('emails.token.link')->with([
                'link'       => $this->buildLink(),
                'whitelabel' => getCurrentWhiteLabelField('display_name')
            ]);
    }

    protected function buildLink()
    {
        return url('/login/token/' . $this->user->token->token . '?' . http_build_query($this->options));
    }
}
