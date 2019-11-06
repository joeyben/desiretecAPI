<?php

namespace App\Mail;

use App\Models\Wishes\Wish;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendAutoOfferEMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
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
        $wish = Wish::where('id',$this->wishId)->first();
        return $this->view('wishes::emails.autooffer')->with([
            'url'         => $wish->whitelabel->domain."/offer/ttlist/".$this->wishId
        ]);;
    }
}
