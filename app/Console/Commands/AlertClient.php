<?php

namespace App\Console\Commands;

use App\Models\Client;
use App\Models\Reservation;
use App\Notifications\ReservationAlertNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class AlertClient extends Command
{
    protected $signature = 'alert:cron';

    protected $description = 'Send alert or reminder to customers before their reservation date';

    public function handle()
    {
//        $currentDate = Carbon::now();
//
//        $alertDate = $currentDate->addDays(2)->format('Y-m-d');
//
//        $reservations = Reservation::whereDate('date', $alertDate)->get();
//
//        foreach ($reservations as $reservation) {
//            $client = Client::where('id', $reservation->client_id)->first();
//            $date = new \DateTime($reservation['date']);
//            $formatDate = $date->format('Y-m-d');
//            $time = new \DateTime($reservation['start_time']);
//            $formatTime = $time->format('g:i A');
//            $data = [
//                "RecipientEmail"=> $client['email'],
//                "Subject"=>"You Have a reservation at march salon",
//                "Body"=>"Hi dear ". $client['name'] . ' please dont forget your reservation in march salon in ' . $formatDate . ' at ' . $formatTime
//            ];
//
//            $res = Http::withOptions([
//                'verify' => false
//            ])
//                ->withHeaders(['Api-Key' => 'vxUHubIc+WsMirIEbhoROFrmXogSadsMJu7FA9DuuJ2uFCrK0RLhMtx9AdKRxHQSCaYQnb/16cbT50UPpCBP3bHU7ie0128QzIi00lc+G1GZ4V8mRWzfNUpPTLfP2b4xEl0IbksbV5HJfNwu3Rkq0npJz6djICH7NTu0/In93QY='])
//                ->post('https://62.72.3.104:7217/api/sender/textsend',$data);
//        }
//
//        return Command::SUCCESS;
    }
}
