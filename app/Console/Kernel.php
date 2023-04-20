<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // last day of year
        $schedule->command('expire:members')->yearlyOn(12, 31, '23:30');
        // first day of year
        $schedule->command('notify:members')->yearlyOn(1, 1, '00:00');

        $schedule->command('weekly:reminder')->weeklyOn(2, '01:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
