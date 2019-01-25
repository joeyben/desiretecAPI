<?php

namespace App\Mail;

use App\Models\Access\User\User;
use Auth;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MessageSent extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = Auth::user()->email;

        return $this->from($email)->subject('Support')->view('emails.messages.message')->with(['bodyMessage' => $this->message]);
    }
}