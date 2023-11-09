<?php

namespace App\Repository\Receiption;

use App\Events\NotificationEvent;
use App\Filter\Reservation\ReservationFilter;
use App\Filter\User\ClientFilter;
use App\Http\Trait\UploadImage;
use App\Models\Client;
use App\Models\Holiday;
use App\Models\Notification;
use App\Models\Reservation;
use App\Models\Transfer;
use App\Repository\BaseRepositoryImplementation;
use App\Statuses\EventTypes;
use App\Statuses\ReservationStatus;
use App\Statuses\ReservationType;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class ReceiptionRepository extends BaseRepositoryImplementation
{
    use UploadImage;
    public function getFilterItems($filter)
    {

        $records = Reservation::query();

        if ($filter instanceof ReservationFilter) {

            $records->when(isset($filter->expert_id), function ($records) use ($filter) {
                $records->whereHas('expert', function ($q) use ($filter) {
                    return $q->where('id', $filter->getExperttId());
                });
            });

            $records->when(isset($filter->type), function ($query) use ($filter) {
                $query->where('type', $filter->getType());
            });

            $records->when(isset($filter->from_date), function ($query) use ($filter) {
                $query->where('date', $filter->getFromDate());
            });

            $records->when(isset($filter->to_date), function ($query) use ($filter) {
                $query->where('date', $filter->getToDate());
            });

            $records->when((isset($filter->from_date) && isset($filter->to_date)), function ($records) use ($filter) {
                $records->WhereBetween('date', [$filter->getFromDate(), $filter->getToDate()])
                    ->orWhereBetween('date', [$filter->getFromDate(), $filter->getToDate()]);
            });

            return  $records->with(['client', 'expert', 'expert.holidays', 'events', 'bridePackage', 'service'])->get();
        }
        return  $records->with(['client', 'expert', 'expert.holidays', 'events', 'bridePackage', 'service'])->get();
    }


    public function list_of_client($filter)
    {
        $records = Client::query();
        if ($filter instanceof ClientFilter) {
            return $records->get();
        }
        return $records->get();
    }

    public function create_client($data)
    {
        DB::beginTransaction();

        try {
            $client = new Client();
            $client->name = $data['name'];
            if (isset($data['email'])) {
                $client->email = $data['email'];
            }
            if (isset($data['phone'])) {
                $client->phone = $data['phone'];
            }
            $client->save();

            $notification = Notification::create([
                'user_id' => Auth::user()->id,
                'notification_type' => EventTypes::CreateClient,
                'title' => Auth::user()->name . ' ' .  'من قبل الموظفة' . ' ' . $client['name'] . ' ' . 'تم اضافة العميل'

            ]);

            event(new NotificationEvent($notification));

            DB::commit();
            if ($client != null) {
                return $client;
            } else {
                return $client;
            }
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error($th->getMessage());
        }
    }

    public function create_reservation($data)
    {

        DB::beginTransaction();
        try {

            $existingReservation = Reservation::where('expert_id', $data['expert_id'])
                ->where('date', $data['date'])
                ->whereIn('status', ReservationStatus::$statuses2)
                ->where(function ($query) use ($data) {
                    $query->where(function ($query) use ($data) {
                        $query->where('start_time', '>=', $data['start_time'])
                            ->where('start_time', '<', $data['end_time']);
                    })
                        ->orWhere(function ($query) use ($data) {
                            $query->where('end_time', '>', $data['start_time'])
                                ->where('end_time', '<=', $data['end_time']);
                        });
                })
                ->first();

            $holidays = Holiday::where('expert_id', $data['expert_id'])->get();

            if ($existingReservation) {

                DB::rollback();
                return "A reservation already exists for this date and time And This Expert";
            } elseif ($holidays->contains('date', $data['date'])) {

                DB::rollback();
                return "You Cannot Add New Reservation In This Date Because This Expert In Holiday,Please Choose Another Date.";
            } else {
                if ($data['start_time'] != $data['end_time'] && $data['end_time'] > $data['start_time']) {
                    $reservation = new Reservation();
                    $reservation->client_id = $data['client_id'];
                    $reservation->expert_id = $data['expert_id'];
                    $reservation->date = $data['date'];
                    $reservation->start_time = $data['start_time'];
                    $reservation->end_time = $data['end_time'];
                    if (isset($data['notes'])) {
                        $reservation->notes = $data['notes'];
                    }
                    $reservation->type = ReservationType::UN_APPROVED;
                    $reservation->status = ReservationStatus::PENDING;
                    $reservation->save();
                    if (isset($data['event'])) {
                        $reservation->events()->attach($data['event']);
                    }
                    if (isset($data['bride_package'])) {
                        $reservation->bridePackage()->attach($data['bride_package']);
                    }
                    if (isset($data['service'])) {
                        $reservation->service()->attach($data['service']);
                    }
                } else {
                    DB::rollback();
                    return "Please Check Correct Time";
                }
            }
            DB::commit();

            $notification = Notification::create([
                'user_id' =>  Auth::user()->id,
                'notification_type' => EventTypes::CreateReservation,
                'title' =>  $reservation->client->phone . ' ' . 'صاحبة الرقم ' . ' ' . $reservation->client->name . ' ' . 'للعميلة ' . ' ' . Auth::user()->name . ' ' . 'حجز جديد تمت إضافته في تاريخ' . ' ' . date('Y-m-d', strtotime($reservation->date)) . ' '   . ' من الساعة ' . $reservation->start_time . ' إلى الساعة ' . $reservation->end_time . ' '  . 'من قبل الموظفة',
                'reservation_id' => $reservation->id,
                'reservation_number' => $reservation->reservation_number
            ]);
            event(new NotificationEvent($notification));

            return $reservation->load(['client', 'expert', 'events', 'bridePackage', 'service']);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
        }
    }
    public function complete_reservation($data)
    {
        DB::beginTransaction();
        try {
            $reservation = Reservation::where('id', $data['reservation_id'])->first();
            $existingReservation = Reservation::where('date',  $reservation->date)
                ->where('status', '<>', ReservationStatus::CANCELED)
                ->where('type', ReservationType::APPROVED)
                ->where(function ($query) use ($reservation) {
                    $query->where(function ($query) use ($reservation) {
                        $query->where('start_time', '>=', $reservation->start_time)
                            ->where('start_time', '<', $reservation->end_time);
                    })
                        ->orWhere(function ($query) use ($reservation) {
                            $query->where('end_time', '>',  $reservation->start_time)
                                ->where('end_time', '<=',  $reservation->end_time);
                        });
                })
                ->first();
            if ($existingReservation) {
                return ['success' => false, 'message' => "Cannot complete this reservation because there is already another reservation at the same date and time.", 'code' => 200];
            }

            $reservation = $this->updateById($data['reservation_id'], $data);
            $client_name = Client::where('id', $reservation->client_id)->first();

            if (Arr::has($data, 'attachment')) {
                $file = Arr::get($data, 'attachment');
                $file_name = $this->uploadReservationAttachment($file);
                $reservation->attachment = $file_name;
            }

            if ($reservation->type = ReservationType::UN_APPROVED) {
                $reservation->type = ReservationType::APPROVED;
            }

            $reservation->save();


            $transfer = Transfer::where('reservation_id', $reservation->id)->first();
            if ($transfer) {
                $updateData = [];
                if (isset($data['reservation_amount']) && $data['reservation_amount'] != $transfer->transfer_amount) {
                    $updateData['transfer_amount'] = $reservation->reservation_amount;
                }
                if (Arr::has($data, 'attachment') && $reservation->attachment != $transfer->attachment) {
                    $updateData['attachment'] = $reservation->attachment;
                }
                if (!empty($updateData)) {
                    $transfer->update($updateData);

                    $newnotification = Notification::create([
                        'user_id' =>  Auth::user()->id,
                        'notification_type' => EventTypes::CompleteReservation,
                        'title' =>  $client_name->phone . ' ' . 'صاحبة الرقم ' . ' ' . $client_name->name . ' ' . 'للعميلة ' . ' ' . Auth::user()->name . ' ' . 'الحجز رقم' . ' ' . $reservation->id . ' ' . 'تم تعديله بتاريخ ' . ' ' . ' ' . date('Y-m-d', strtotime($reservation->date)) . ' ' . 'من قبل الموظفة',
                        'reservation_id' => $reservation->id,
                        'reservation_number' => $reservation->reservation_number
                    ]);
                    $notification = Notification::create([
                        'user_id' => Auth::user()->id,
                        'notification_type' => EventTypes::UpdateTransfer,
                        'title' => Auth::user()->name . ' ' . 'تم تعديل التحويلة'  . ' ' . $transfer->id . ' ' . 'من قبل الموظفة'
                    ]);
                    event(new NotificationEvent($notification));
                    event(new NotificationEvent($newnotification));
                } elseif ($data['reservation_amount'] == $transfer->transfer_amount && !Arr::has($data, 'attachment')) {
                    $notification = Notification::create([
                        'user_id' =>  Auth::user()->id,
                        'notification_type' => EventTypes::CompleteReservation,
                        'title' => ' ' . Auth::user()->name .  ' ' . 'الحجز رقم' . ' ' . $reservation->id . ' ' . 'تم تعديله بتاريخ ' . ' '  . ' ' . date('Y-m-d', strtotime($reservation->date)) . ' '  . 'من قبل الموظفة',
                        'reservation_id' => $reservation->id,
                        'reservation_number' => $reservation->reservation_number
                    ]);
                    event(new NotificationEvent($notification));
                }
            } else {
                Transfer::create([
                    'user_id' => auth()->user()->id,
                    'client_id' => $reservation->client_id,
                    'date' => date('Y-m-d'),
                    'transfer_amount' => $reservation->reservation_amount,
                    'attachment' => $reservation->attachment,
                    'reservation_id' => $reservation->id
                ]);
                $notification = Notification::create([
                    'user_id' =>  Auth::user()->id,
                    'notification_type' => EventTypes::CompleteReservation,
                    'title' =>  $client_name->phone . ' ' . 'صاحبة الرقم ' . ' ' . $client_name->name . ' ' . 'للعميلة ' . ' ' . Auth::user()->name . ' ' . 'الحجز رقم' . ' ' . $reservation->id . ' ' . 'تم تثبيته بتاريخ ' . ' ' . ' ' . date('Y-m-d', strtotime($reservation->date)) . ' ' . ' من الساعة ' . $reservation->start_time . ' إلى الساعة ' . $reservation->end_time . ' ' . 'من قبل الموظفة',
                    'reservation_id' => $reservation->id,
                    'reservation_number' => $reservation->reservation_number
                ]);
                event(new NotificationEvent($notification));
            }


            DB::commit();

            return ['success' => true, 'data' =>  $reservation->load('expert', 'client'), 'code' => 200];
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function cancle_reservation($data)
    {
        DB::beginTransaction();
        try {
            $reservation = $this->getById($data['reservation_id']);
            $client_name = Client::where('id', $reservation->client_id)->first();
            $reservation->update([
                'status' => ReservationStatus::CANCELED,
                'reason_cancle' => $data['reason_cancle']
            ]);

            DB::commit();

            if ($reservation === null) {
                return response()->json(['message' => "Reservation was not Cancled"]);
            }
            $notification = Notification::create([
                'user_id' =>  Auth::user()->id,
                'notification_type' => EventTypes::CancelReservation,
                'title' =>  $client_name->phone . ' ' . 'صاحبة الرقم ' . ' ' . $client_name->name . ' ' . 'للعميلة ' . ' ' . Auth::user()->name . ' ' . 'الحجز رقم' . ' ' . $reservation->id . ' ' . 'تم الغاءه' . ' ' . ' ' . 'من قبل الموظفة',
                'reservation_id' => $reservation->id,
                'reservation_number' => $reservation->reservation_number
            ]);

            event(new NotificationEvent($notification));
            return $reservation->load(['client', 'expert', 'events', 'bridePackage', 'service']);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return response()->json(['message' => $e->getMessage()]);
        }
    }
    public function delay_reservation($data)
    {
        DB::beginTransaction();
        try {
            $reservation = $this->getById($data['reservation_id']);
            if (isset($data['delay_date'])) {
                $existingReservation = Reservation::where('date', $data['delay_date'])
                    ->whereIn('status', ReservationStatus::$statuses3)
                    ->where(function ($query) use ($data) {
                        $query->where(function ($query) use ($data) {
                            $query->where('start_time', '>=', $data['start_time'])
                                ->where('start_time', '<', $data['end_time']);
                        })
                            ->orWhere(function ($query) use ($data) {
                                $query->where('end_time', '>', $data['start_time'])
                                    ->where('end_time', '<=', $data['end_time']);
                            });
                    })
                    ->first();

                if ($existingReservation) {
                    return "You Cannot Delay Reservation To This Date Because There Is a Prior Reservation For This Date";
                } else {
                    $reservation->update([
                        'date' => $data['delay_date'],
                        'delay_date' => $data['delay_date'],
                        'start_time' => $data['start_time'],
                        'end_time' => $data['end_time'],
                        'reason_delay' => $data['reason_delay'],
                        'status' => ReservationStatus::DELAYED,
                    ]);
                }
            } else {
                $reservation->update([
                    'reason_delay' => $data['reason_delay'],
                    'status' => ReservationStatus::DELAYED,
                ]);
            }
            $reservation->save();
            DB::commit();
            if ($reservation === null) {
                return response()->json(['message' => "Reservation was not Delayed"]);
            }
            $notification = Notification::create([
                'user_id' =>  Auth::user()->id,
                'notification_type' => EventTypes::DelayReservation,
                'title' =>  $reservation->client->phone . ' ' . 'صاحبة الرقم ' .  $reservation->client->name . ' ' . 'للعميلة' . ' ' . Auth::user()->name .  ' ' . 'تم تأخير الحجز رقم' . ' ' . $reservation->id . ' ' . 'إلى تاريخ' . ' '  . ' ' . date('Y-m-d', strtotime($reservation->delay_date)) . ' '   . ' من الساعة ' . $reservation->start_time . ' إلى الساعة ' . $reservation->end_time . ' '  . 'من قبل الموظفة',
                'reservation_id' => $reservation->id,
                'reservation_number' => $reservation->reservation_number
            ]);
            event(new NotificationEvent($notification));
            return $reservation->load(['client', 'expert', 'events', 'bridePackage', 'service']);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return response()->json(['message' => $e->getMessage()]);
        }
    }
    public function update_client($data)
    {
        DB::beginTransaction();

        try {
            $client = Client::where('id', $data['client_id'])->first();

            if (isset($data['name'])) {
                $client->name = $data['name'];
            }
            if (isset($data['email'])) {
                $client->email = $data['email'];
            }
            if (isset($data['phone'])) {
                $client->phone = $data['phone'];
            }

            $client->save();

            DB::commit();

            return $client;
        } catch (\Throwable $th) {
            DB::rollback();
        }
    }

    public function model()
    {
        return Reservation::class;
    }
}
