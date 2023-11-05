<?php

namespace App\Http\Resources\Rservation;

use Illuminate\Http\Resources\Json\JsonResource;

class ReservationHistory extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'is_confirmed' => $this->is_confirmed,
            'date' => $this->date,
            'status' => $this->status,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'arrive_date' => $this->arrive_date,
            'arrive_time' => $this->arrive_time,
            'status' => $this->status,
            'reservation_id'  => $this->reservation->id,
            'expert'  => $this->expert->name,
            'client'  => $this->client->name,
        ];
    }
}
