<?php

namespace App\Jobs;

use App\Mail\SendAutoOfferEMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class sendAutoOffersMail implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $details;
    protected $wishId;
    protected $wlEmail;

    public function __construct($details, $wishId, $wlEmail)
    {
        $this->details = $details;
        $this->wishId = $wishId;
        $this->wlEmail = $wlEmail;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $email = new SendAutoOfferEMail($this->wishId, $this->details['type'], $this->details['token'], $this->wlEmail, $this->details);
        Mail::to($this->details['email'])->send($email);
    }
}
