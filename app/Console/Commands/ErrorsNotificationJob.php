<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ErrorsNotificationJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'error:notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'activate warning email notification when a huge number of logs';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
    }
}
