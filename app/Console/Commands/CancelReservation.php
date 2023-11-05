<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\Reservation;
use App\Statuses\ReservationStatus;
use App\Statuses\ReservationType;

class CancelReservation extends Command
{
    protected $signature = 'cancel_reservation:cron';

    protected $description = 'Delete reservations that are older than a month and have a status other than confirmed';

    public function handle()
    {

        $reservations = Reservation::where('status', ReservationStatus::DELAYED)
            ->where('delay_date', null)
            ->where('date', '<=', Carbon::now()->subMonthNoOverflow())
            ->get();

        foreach ($reservations as $reservation) {
            $reservation->delete();
        }

        return Command::SUCCESS;
    }
}
