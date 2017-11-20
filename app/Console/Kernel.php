<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * @param Schedule $schedule
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('bx:sitemap')
            ->timezone('Europe/Moscow')
            ->daily();

        $schedule->command('bx:file-sort')
            ->timezone('Europe/Moscow')
            ->hourlyAt(10);

        $schedule->command('bx:tag-block')
            ->timezone('Europe/Moscow')
            ->hourlyAt(20);

        $schedule->command('bx:instagram')
            ->timezone('Europe/Moscow')
            ->hourlyAt(30);
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
