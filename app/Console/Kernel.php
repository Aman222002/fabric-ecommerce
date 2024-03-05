<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected $commands = [
        Commands\CleanupJobs::class,
        Commands\CheckPlanValidity::class,
        Commands\CleanResetToken::class,
    ];
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('jobs:cleanup')->daily();
        $schedule->command('check:planvalidity')->everyMinute();
        $schedule->command('app:clean-reset-token')->everyFourMinutes();
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
