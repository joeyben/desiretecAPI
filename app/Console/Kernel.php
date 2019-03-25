<?php

namespace App\Console;

use App\Console\Commands\InstallAppCommand;
use App\Console\Commands\WhitelabelMakeRouteCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Modules\LanguageLines\Console\CopyLanguageCommand;
use Modules\LanguageLines\Console\ExportLanguageLinesCommand;
use Modules\LanguageLines\Console\ImportLanguageFilesCommand;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        InstallAppCommand::class,
        WhitelabelMakeRouteCommand::class,
        ImportLanguageFilesCommand::class,
        CopyLanguageCommand::class,
        ExportLanguageLinesCommand::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     */

    /**
     * Register the Closure based commands for the application.
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
