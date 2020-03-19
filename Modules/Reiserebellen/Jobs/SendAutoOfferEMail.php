<?php

namespace Modules\Reiserebellen\Jobs;

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

        return $this->view('wishes::emails.autooffer-reiserebellen')->with([
            'url'         => $wish->whitelabel->domain . '/offerwl/create/' . $this->wishId
        ]);
    }
}
