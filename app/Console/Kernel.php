<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * These jobs run in a default, single-node configuration.
     * However, you may want to run some of these jobs in a cluster or distributed configuration.
     *
     * The Artisan command scheduler supports a variety of event-based schedules. Here are some examples:
     *
     *      $schedule->command('inspire')->hourly();
     *      $schedule->command('inspire')->daily();
     *      $schedule->command('inspire')->friday();
     *
     * Some of the events available:
     *
     *      $schedule->exec('echo $USER')->daily();
     *      $schedule->exec('node /path/to/artisan schedule:run --verbose')->daily();
     *      $schedule->command('php /path/to/artisan schedule:run --verbose')->daily();
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // ... existing code ...
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
} 