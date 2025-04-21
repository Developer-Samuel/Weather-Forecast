<?php

namespace App\Console;

use App\Console\Commands\LoadCountries;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        LoadCountries::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('countries:load')->daily();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
