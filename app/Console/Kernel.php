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
        $schedule->call('\Fresh\Estet\Repositories\SitemapRepository@index')->dailyAt('10:30');
        $schedule->call('\Fresh\Estet\Http\Controllers\SitemapController@index')->dailyAt('17:10');
        $schedule->command('getSubscribe')->dailyAt('11:30')->withoutOverlapping();
        $schedule->command('sendNews')->dailyAt('11:32')->withoutOverlapping();
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
