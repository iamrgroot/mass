<?php

namespace App\Console;

use App\Console\Commands\CpuLogCommand;
use App\Console\Commands\DiskLogCommand;
use App\Console\Commands\MemoryLogCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     */
    protected function schedule(Schedule $schedule): void
    {
        $thirty_minutes = [
            DiskLogCommand::class,
        ];

        foreach ($thirty_minutes as $command) {
            $schedule->command($command)->everyThirtyMinutes();
        }

        $every_minute = [
            CpuLogCommand::class,
            MemoryLogCommand::class,
        ];

        foreach ($every_minute as $command) {
            $schedule->command($command)->everyMinute();
        }
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
