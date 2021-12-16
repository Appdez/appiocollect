<?php

namespace App\Console;

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
        Commands\SendReport::class,
        Commands\SendHourlyRaport::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
         $schedule->command('send:report')->monthlyOn(30,'6:0')->withoutOverlapping()->emailOutputTo('nelsonmutane@gmail.com');
         $schedule->command('send:hourly-report')->everyMinute()->days([
            Schedule::MONDAY,Schedule::THURSDAY,Schedule::WEDNESDAY,Schedule::TUESDAY,Schedule::FRIDAY
        ])->withoutOverlapping()->emailOutputTo('nelsonmutane@gmail.com');
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
