<?php

namespace App\Http\Resources\Expert;

use App\Http\Resources\Holiday\HolidayResource;
use App\Http\Resources\Rservation\ReservationResource;
use App\Http\Resources\Service\ServiceResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ExpertResource extends JsonResource
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
            'name' => $this->name,
            'position' => $this->position,
            'image' => $this->image ? asset($this->image) : null,
            'reservations' => ReservationResource::collection($this->whenLoaded('reservations')),
            'holidays' => HolidayResource::collection($this->whenLoaded('holidays')),
        ];
    }
}
