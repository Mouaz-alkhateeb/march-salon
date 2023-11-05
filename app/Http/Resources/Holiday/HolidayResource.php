<?php

namespace App\Http\Resources\Holiday;

use Illuminate\Http\Resources\Json\JsonResource;

class HolidayResource extends JsonResource
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
            'date' => $this->date,
            'expert' => $this->whenLoaded('expert', function () {
                return [
                    'id' => $this->expert->id,
                    'name' => $this->expert->name,
                ];
            }),

        ];
    }
}
