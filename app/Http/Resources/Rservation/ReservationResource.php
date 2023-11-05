<?php

namespace App\Http\Resources\Rservation;

use App\Http\Resources\BridePackage\BridePackageResource;
use App\Http\Resources\Event\EventResource;
use App\Http\Resources\Expert\ExpertResource;
use App\Http\Resources\Service\ServiceResource;
use App\Services\Admin\AdminService;
use App\Services\Receiption\ReceiptionService;
use App\Statuses\ReservationStatus;
use Illuminate\Http\Resources\Json\JsonResource;
use Psy\Readline\Hoa\EventSource;

class ReservationResource extends JsonResource
{


    public function toArray($request)
    {

        $eventsNotEmpty = $this->events->isNotEmpty();
        $bridePackageNotEmpty = $this->bridePackage->isNotEmpty();

        if ($eventsNotEmpty) {
            $resource = EventResource::collection($this->events);
        } elseif ($bridePackageNotEmpty) {
            $resource = BridePackageResource::collection($this->bridePackage);
        } else {
            $resource = ServiceResource::collection($this->service);
        }


        if ($this->status == ReservationStatus::COMPLETED) {
            return [
                'id' => $this->id,
                'date' => $this->date,
                'amount_type' => $resource,
                'start_time' => $this->start_time,
                'end_time' => $this->end_time,
                'reservation_number' => $this->reservation_number,
                'type' => $this->type,
                'status' => $this->status,
                'reservation_amount' => $this->reservation_amount,
                'payment_status' => $this->payment_status,
                'payment_way' => $this->payment_way,
                'notes' => $this->notes,
                'attachment' => $this->attachment ? asset($this->attachment) : null,
                'expert' => ExpertResource::make($this->whenLoaded('expert')),
                'client' => $this->whenLoaded('client', function () {
                    return [
                        'id' => $this->client->id,
                        'name' => $this->client->name,
                        'phone' => $this->client->phone,
                        'total' => ReceiptionService::TotalAmount($this->client->id),
                    ];
                }),
                'is_confirmed' => AdminService::isConfirmed($this->id)

            ];
        } elseif ($this->status == ReservationStatus::PENDING) {
            return [
                'id' => $this->id,
                'date' => $this->date,
                'amount_type' => $resource,
                'start_time' => $this->start_time,
                'end_time' => $this->end_time,
                'reservation_number' => $this->reservation_number,
                'type' => $this->type,
                'status' => $this->status,
                'reservation_amount' => $this->reservation_amount,
                'payment_status' => $this->payment_status,
                'payment_way' => $this->payment_way,
                'notes' => $this->notes,
                'attachment' => $this->attachment ? asset($this->attachment) : null,
                'expert' => ExpertResource::make($this->whenLoaded('expert')),
                'client' => $this->whenLoaded('client', function () {
                    return [
                        'id' => $this->client->id,
                        'name' => $this->client->name,
                        'phone' => $this->client->phone,

                    ];
                }),
            ];
        } elseif ($this->status == ReservationStatus::DELAYED) {
            return [
                'id' => $this->id,
                'date' => $this->date,
                'amount_type' => $resource,
                'start_time' => $this->start_time,
                'end_time' => $this->end_time,
                'reservation_number' => $this->reservation_number,
                'type' => $this->type,
                'status' => $this->status,
                'reservation_amount' => $this->reservation_amount,
                'payment_status' => $this->payment_status,
                'payment_way' => $this->payment_way,
                'delay_date' => $this->delay_date,
                'reason_delay' => $this->reason_delay,
                'notes' => $this->notes,
                'attachment' => $this->attachment ? asset($this->attachment) : null,
                'expert' => ExpertResource::make($this->whenLoaded('expert')),
                'client' => $this->whenLoaded('client', function () {
                    return [
                        'id' => $this->client->id,
                        'name' => $this->client->name,
                        'phone' => $this->client->phone,

                    ];
                }),
            ];
        } else {
            return [
                'id' => $this->id,
                'date' => $this->date,
                'amount_type' => $resource,
                'start_time' => $this->start_time,
                'end_time' => $this->end_time,
                'reservation_number' => $this->reservation_number,
                'type' => $this->type,
                'status' => $this->status,
                'reservation_amount' => $this->reservation_amount,
                'payment_status' => $this->payment_status,
                'payment_way' => $this->payment_way,
                'reason_cancle' => $this->reason_cancle,
                'notes' => $this->notes,
                'attachment' => $this->attachment ? asset($this->attachment) : null,
                'expert' => ExpertResource::make($this->whenLoaded('expert')),
                'client' => $this->whenLoaded('client', function () {
                    return [
                        'id' => $this->client->id,
                        'name' => $this->client->name,
                        'phone' => $this->client->phone,

                    ];
                }),
            ];
        }
    }
}
