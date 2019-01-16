<?php

namespace App\Console;

use App\Console\Commands\InstallAppCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Modules\Whitelabels\Console\WhitelabelMakeRouteCommand;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
    InstallAppCommand::class,
    Commands\ClearExpiredUserLoginTokens::class,
    WhitelabelMakeRouteCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     */
    protected function schedule(Schedule $schedule)
    {
        //$schedule->command('auth:clear-tokens')->daily();
    }

    /**
     * Register the Closure based commands for the application.
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
