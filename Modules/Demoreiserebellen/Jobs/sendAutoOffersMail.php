<?php

namespace Modules\Demoreiserebellen\Jobs;

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

    public function __construct($details, $wishId)
    {
        $this->details = $details;
        $this->wishId = $wishId;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $email = new SendAutoOfferEMail($this->wishId, $this->details['type']);
        Mail::to($this->details['email'])->send($email);
    }
}
