<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\SendAutoOfferEMail;
use Illuminate\Support\Facades\Mail;

class sendAutoOffersMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $details;
    protected $wishId;
    public function __construct($details, $wishId)
    {
        $this->details = $details;
        $this->wishId = $wishId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new SendAutoOfferEMail($this->wishId);
        Mail::to($this->details['email'])->send($email);
    }
}
