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
        $schedule->call('\Fresh\Estet\Repositories\SitemapRepository@index')->dailyAt('13:46');
        $schedule->call('\Fresh\Estet\Http\Controllers\SitemapController@index')->dailyAt('13:46');
        $schedule->command('getSubscribe')->dailyAt('13:47')->withoutOverlapping();
//        $schedule->command('getSubscribe')->everyFiveMinutes();
        $schedule->command('sendNews')->dailyAt('13:47')->withoutOverlapping();
//        $schedule->command('sendNews')->everyFiveMinutes();
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
