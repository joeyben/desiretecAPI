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

    public function __construct($wishId, $type)
    {
        $this->wishId = $wishId;
        $this->type = $type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $wish = Wish::where('id', $this->wishId)->first();

        return $this->subject(trans('autooffer.email.subject'))->view('wishes::emails.autooffer')->with([
            'url'         => $wish->whitelabel->domain . '/offer/ttlist/' . $this->wishId
        ]);
    }
}
