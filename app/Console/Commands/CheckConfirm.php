<?php

namespace App\Console\Commands;

use App\Models\Reservation;
use App\Models\ReservationHistory;
use App\Statuses\ConfirmedType;
use App\Statuses\ReservationType;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckConfirm extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:confirm';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $currentDate = Carbon::now()->format('Y-m-d');
        $currentTime = Carbon::now()->format('H:i:s');

        $reservations = Reservation::where('type', ReservationType::APPROVED)
            ->where(function ($query) use ($currentDate, $currentTime) {
                $query->where('date', $currentDate)
                    ->where('start_time', '<', $currentTime);
            })
            ->orWhere('date', '>', $currentDate)
            ->with('reservationHistory')
            ->get();
        foreach ($reservations as $reservation) {
            $reservation_history = new ReservationHistory();
            $reservation_history->reservation_id = $reservation->id;
            $reservation_history->expert_id = $reservation->expert_id;
            $reservation_history->client_id = $reservation->client_id;
            $reservation_history->is_confirmed = ConfirmedType::NOT_COMMING;
            $reservation_history->date = $reservation->date;
            $reservation_history->start_time = $reservation->start_time;
            $reservation_history->end_time = $reservation->end_time;
            $reservation_history->status = $reservation->status;
            $reservation_history->save();
        }

        return Command::SUCCESS;
    }
}
