<?php

namespace Fresh\Estet\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\getSubscribe::class,
        Commands\SendNews::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
//        $schedule->call('\Fresh\Estet\Repositories\SubscribersRepository@getAll')->everyFiveMinutes();
        $schedule->call('\Fresh\Estet\Repositories\SitemapRepository@index')->dailyAt('01:30');
        $schedule->command('getSubscribe')->dailyAt('10:30')->withoutOverlapping();
        $schedule->command('sendNews')->dailyAt('10:32')->withoutOverlapping();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
