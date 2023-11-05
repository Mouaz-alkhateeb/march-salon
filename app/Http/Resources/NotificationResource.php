<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if ($this->notification_type == "create-reservation" || $this->notification_type == "complete-reservation" ||  $this->notification_type == "cancel-reservation" || $this->notification_type == "delay-reservation") {
            return [
                'id' => $this->id,
                'title' => $this->title,
                'type' => $this->notification_type,
                'reservation_id' => $this->reservation_id,
                'reservation_number' => $this->reservation_number,
                'created_at' => $this->created_at->diffForHumans(),
                'user_id' => $this->user_id,
                'user' => $this->user,
            ];
        } else {
            return [
                'id' => $this->id,
                'title' => $this->title,
                'type' => $this->notification_type,
                'created_at' => $this->created_at->diffForHumans(),
                'user_id' => $this->user_id,
                'user' => $this->user,
            ];
        }
    }
}
