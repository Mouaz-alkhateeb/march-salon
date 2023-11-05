<?php

namespace App\Query\Admin;

use App\Models\Client;
use App\Models\Reservation;
use Illuminate\Support\Facades\DB;

class MostReservationQuery
{
    public function most_active_client(): object
    {
        $mostClientReservations = $this->mostClientReservations();
        $result = [
            'most_client_reservations' => $mostClientReservations,
        ];
        return (object) $result;
    }
    private function mostClientReservations()
    {
        $top5ClientReservations = Reservation::select('client_id', DB::raw('count(*) as total'))
            ->groupBy('client_id')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        $results = [];

        foreach ($top5ClientReservations as $reservation) {
            $clientId = $reservation->client_id;
            $clientData = Client::find($clientId);
            $result = [
                'total' => $reservation->total,
                'client' => $clientData,
            ];
            $results[] = (object) $result;
        }

        return $results;
    }
}
