<?php

namespace App\Console;

use App\Console\Commands\AlertClient;
use App\Console\Commands\CancelReservation;
use App\Console\Commands\CheckConfirm;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    protected $commands = [
        AlertClient::class,
        CancelReservation::class,
        CheckConfirm::class
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('alert:cron')->dailyAt('59:23');
        $schedule->command('cancel_reservation:cron')->dailyAt('59:23');
        $schedule->command('check:confirm')->hourly();
    }

    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
