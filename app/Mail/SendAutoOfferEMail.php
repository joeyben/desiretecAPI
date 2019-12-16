<?php

namespace App\Mail;

use App\Models\Wishes\Wish;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendAutoOfferEMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * Create a new message instance.
     */
    protected $wishId;
    protected $type;
    protected $token;
    protected $details;

    public function __construct($wishId, $type, $token, $details)
    {
        $this->wishId = $wishId;
        $this->type = $type;
        $this->token = $token;
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $wish = Wish::where('id', $this->wishId)->first();

        return $this->from(getCurrentWhiteLabelEmail(), $this->details['email_name'])
            ->subject($this->details['email_subject'])
            ->html($this->details['email_content'], 'text/html');
    }
}
