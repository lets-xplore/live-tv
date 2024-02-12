<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
Use App\Console\Commands\VideoImportCronJob;
class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */


     protected $commands = [
        VideoImportCronJob::class,
    ];


    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('vimeo:video-import')->cron('0 */12 * * *');




    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {

        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
