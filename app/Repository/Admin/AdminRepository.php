<?php

namespace App\Repository\Admin;

use App\ApiHelper\SortParamsHelper;
use App\Events\CreateClientEvent;
use App\Events\NotificationEvent;
use App\Filter\Reservation\ReservationHistoryFilter;
use App\Filter\Transfer\TransferFilter;
use App\Filter\User\ClientFilter;
use App\Http\Trait\UploadImage;
use App\Models\Expert;
use App\Models\Holiday;
use App\Models\Notification;
use App\Models\Reservation;
use App\Models\ReservationHistory;
use App\Models\Service;
use App\Models\Transfer;
use App\Models\User;
use App\Repository\BaseRepositoryImplementation;
use App\Statuses\ConfirmedType;
use App\Statuses\EventTypes;
use App\Statuses\HavePermission;
use App\Statuses\PermissionType;
use App\Statuses\ReservationStatus;
use App\Statuses\ReservationType;
use App\Statuses\UserType;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;


class AdminRepository extends BaseRepositoryImplementation
{
    use UploadImage;
    public function getFilterItems($filter)
    {

        $records = Transfer::query();

        if ($filter instanceof TransferFilter) {

            $records->when(isset($filter->starting_date), function ($query) use ($filter) {
                $query->where('date', $filter->getStartingDate());
            });
            $records->when(isset($filter->end_date), function ($query) use ($filter) {
                $query->where('date', $filter->getEndingDate());
            });

            $records->when((isset($filter->starting_date) && isset($filter->end_date)), function ($records) use ($filter) {
                $records->whereBetween('date', [$filter->getStartingDate(), $filter->getEndingDate()])
                    ->orWhereBetween('date', [$filter->getStartingDate(), $filter->getEndingDate()]);
            });

            $records->when(isset($filter->transfer_amount), function ($records) use ($filter) {
                $records->where('transfer_amount', 'LIKE', '%' . $filter->getTransferAmount() . '%');
            });

            $records->when(isset($filter->user_id), function ($records) use ($filter) {
                $records->whereHas('user', function ($q) use ($filter) {
                    return $q->where('id', $filter->getUserId());
                });
            });
            $records->when(isset($filter->client_id), function ($records) use ($filter) {
                $records->whereHas('client', function ($q) use ($filter) {
                    return $q->where('id', $filter->getClientId());
                });
            });

            return $records->with(['client', 'user'])->get();
        }

        return $records->with(['client', 'user'])->get();
    }

    public function model()
    {
        return Transfer::class;
    }
    public function create_admin($data)
    {
        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'type' => UserType::ADMIN,
                'permission_to_delay' => HavePermission::TRUE,
                'permission_to_delete' => HavePermission::TRUE,
                'permission_to_update' => HavePermission::TRUE
            ]);
            DB::commit();
            return $user;
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error($th->getMessage());
        }
    }
    public function create_receiption($data)
    {
        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'type' => UserType::RECEPTION,
                'permission_to_delay' => HavePermission::FALSE,
                'permission_to_delete' => HavePermission::FALSE,
                'permission_to_update' => HavePermission::FALSE
            ]);

            DB::commit();
            $notification = Notification::create([
                'user_id' => Auth::user()->id,
                'notification_type' => EventTypes::CreateReciption,
                'title' => Auth::user()->name . ' ' .  'من قبل' . ' ' . $data['name'] . ' ' . 'تم اضافة موظف استقبال جديد اسمه'

            ]);

            event(new NotificationEvent($notification));
            return $user;
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error($th->getMessage());
        }
    }

    public function create_transfer($data)
    {
        DB::beginTransaction();
        try {
            $transfer = new Transfer();
            if (Arr::has($data, 'attachment')) {
                $file = Arr::get($data, 'attachment');
                $file_name = $this->uploadTransferAttachment($file);
                $transfer->attachment = $file_name;
            }
            $transfer->user_id = auth()->user()->id;
            $transfer->client_id = $data['client_id'];
            $transfer->date = $data['date'];
            $transfer->transfer_amount = $data['transfer_amount'];
            $transfer->save();
            DB::commit();
            $notification = Notification::create([
                'user_id' => Auth::user()->id,
                'notification_type' => EventTypes::CreateTransfer,
                'title' => Auth::user()->name . ' ' . 'تمت اضافة تحوية جديدة بمبلغ قدره '  . $transfer->transfer_amount   . ' من قبل الموظف ',

            ]);

            event(new NotificationEvent($notification));
            return $transfer->load(['user', 'client']);
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error($th->getMessage());
        }
    }

    public function update_transfer($data)
    {
        DB::beginTransaction();
        try {
            $transfer = $this->updateById($data['transfer_id'], $data);
            $reservation = Reservation::where('id', $transfer->reservation_id)->first();

            if (Arr::has($data, 'attachment')) {
                $file = Arr::get($data, 'attachment');
                $file_name = $this->deleteAndUploadTransferAttachment($file, $transfer->id, 'attachment');
                $transfer->attachment = $file_name;
                $transfer->save();

                if ($reservation) {
                    $reservation->update([
                        'reservation_amount' => $transfer->transfer_amount,
                        'attachment' => $transfer->attachment
                    ]);
                }
            } else {
                if ($reservation) {
                    $reservation->update([
                        'reservation_amount' => $transfer->transfer_amount,
                    ]);
                }
            }

            DB::commit();

            return $transfer->load('user', 'client');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function delete_transfer(int $id)
    {
        $transfer = Transfer::where('id', $id)->first();

        if ($transfer) {
            $transfer->delete();
            return response()->json(['message' => 'Transfer Delete Successfully'], 200);
        } else {
            return response()->json(['message' => 'Transfer Not Found'], 404);
        }
    }


    public function update_receiption($data)
    {
        DB::beginTransaction();
        try {
            $receiption = User::where('id', $data['receiption_id'])->first();
            if (isset($data['name'])) {
                $receiption->name = $data['name'];
            }
            if (isset($data['email'])) {
                $receiption->email = $data['email'];
            }
            if (isset($data['password'])) {
                $receiption->password = Hash::make($data['password']);
            }
            $receiption->save();
            DB::commit();

            return $receiption;
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function create_service($data)
    {
        DB::beginTransaction();
        try {
            $service = Service::create([
                'name' => $data['name'],
            ]);
            DB::commit();

            return $service;
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error($th->getMessage());
        }
    }

    public function create_expert($data)
    {
        DB::beginTransaction();
        try {
            $expert = new Expert();
            if (Arr::has($data, 'image')) {
                $file = Arr::get($data, 'image');
                $file_name = $this->uploadExpertImage($file);
                $expert->image = $file_name;
            }
            $expert->name = $data['name'];
            $expert->position = $data['position'];
            $expert->save();
            DB::commit();
            $notification = Notification::create([
                'user_id' => Auth::user()->id,
                'notification_type' => EventTypes::CreateExpert,
                'title' => Auth::user()->name . ' ' . 'الأرتست في النظام' . ' ' .  'من قبل الموظفة' . ' ' . $data['name'] . ' ' . 'تم اضافة الموظف'
            ]);

            event(new NotificationEvent($notification));
            return $expert;
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error($th->getMessage());
        }
    }


    public function delete_receiption(int $id)
    {
        $receiption = User::where('id', $id)->first();

        if ($receiption) {
            $receiption->delete();
            return response()->json(['message' => 'Receiption Delete Successfully'], 200);
        } else {
            return response()->json(['message' => 'Receiption Not Found'], 404);
        }
    }

    public function list_of_experts($filter)
    {
        $records = Expert::query();
        return $records->with(['holidays', 'reservations'])->get();
    }

    public function list_of_services($filter)
    {
        $records = Service::query();
        return $records->get();
    }
    public function list_of_receiptions($filter)
    {
        $records = User::query()->where('type', UserType::RECEPTION);
        return $records->get();
    }

    public function number_daily_clients($filter)
    {
        $records = Reservation::query();
        $today = now()->format('Y-m-d');

        if ($filter instanceof ClientFilter && isset($filter->date)) {
            $records->whereDate('date', $filter->getDate());
        } else {
            $records->whereDate('date', 'like', $today . '%');
        }

        $count = $records->count();

        $response = ['number_daily_clients' => $count];

        return $response;
    }

    public function reservations_history($filter)
    {
        $records = ReservationHistory::query()->with(['reservation', 'client', 'expert']);

        if ($filter instanceof ReservationHistoryFilter) {

            $records->when(isset($filter->date), function ($query) use ($filter) {
                $query->where('date', $filter->getDate());
            });

            return $records->get();
        }
        return $records->get();
    }

    public function create_holiday($data)
    {
        DB::beginTransaction();
        try {
            $existHoliday = Holiday::where('date', $data['date'])
                ->where('expert_id', $data['expert_id'])
                ->first();
            $expert = Expert::where('id', $data['expert_id'])->first();

            if (!$existHoliday) {
                $holiday = Holiday::create([
                    'date' => $data['date'],
                    'expert_id' => $data['expert_id'],
                ]);
            } else {
                $existHoliday->delete();
            }

            DB::commit();


            $notification = Notification::create([
                'user_id' => Auth::user()->id,
                'notification_type' => EventTypes::CreateHoliday,
                'title' => $data['expert_id'] . ' ' . 'ذو المعرف' . ' ' . $expert->name . ' ' . 'تم اضافة عطلة جديدة للخبير'

            ]);

            event(new NotificationEvent($notification));

            if ($holiday != null) {
                return $holiday;
            } else {
                $holiday->load('expert');
            }
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error($th->getMessage());
        }
    }

    public function chang_permission($data)
    {
        DB::beginTransaction();
        try {
            $receiption = User::where('id', $data['receiption_id'])->first();

            if ($receiption->type == UserType::RECEPTION) {
                if ($data['type'] == PermissionType::DELAY && $data['can'] == HavePermission::TRUE) {
                    $receiption->update([
                        'permission_to_delay' => HavePermission::TRUE
                    ]);
                } elseif ($data['type'] == PermissionType::DELAY && $data['can'] == HavePermission::FALSE) {
                    $receiption->update([
                        'permission_to_delay' => HavePermission::FALSE
                    ]);
                } elseif ($data['type'] == PermissionType::CANCLE && $data['can'] == HavePermission::TRUE) {
                    $receiption->update([
                        'permission_to_delete' => HavePermission::TRUE
                    ]);
                } elseif ($data['type'] == PermissionType::CANCLE && $data['can'] == HavePermission::FALSE) {
                    $receiption->update([
                        'permission_to_delete' => HavePermission::FALSE
                    ]);
                } elseif ($data['type'] == PermissionType::UPDATE && $data['can'] == HavePermission::TRUE) {
                    $receiption->update([
                        'permission_to_update' => HavePermission::TRUE
                    ]);
                } elseif ($data['type'] == PermissionType::UPDATE && $data['can'] == HavePermission::FALSE) {
                    $receiption->update([
                        'permission_to_update' => HavePermission::FALSE
                    ]);
                }
            } else {
                return 'Failed';
            }

            DB::commit();
            return $receiption;
        } catch (\Throwable $th) {
            DB::rollback();
        }
    }

    public function update_expert($data)
    {
        DB::beginTransaction();

        try {
            $expert = Expert::where('id', $data['expert_id'])->first();

            if (isset($data['name'])) {
                $expert->name = $data['name'];
            }
            if (isset($data['position'])) {
                $expert->position = $data['position'];
            }

            if (Arr::has($data, 'image')) {
                $file = Arr::get($data, 'image');
                $file_name = $this->uploadExpertImage($file);
                $expert->image = $file_name;
            }


            $expert->save();

            DB::commit();

            return $expert;
        } catch (\Throwable $th) {
            DB::rollback();
        }
    }

    public function confirm_reservation($id)
    {

        DB::beginTransaction();
        try {
            $reservation = Reservation::where('id', $id)->first();
            if (!$reservation) {
                DB::rollback();
                return response()->json(['message' => "Reservation not found."], 404);
            }
            if ($reservation->type == ReservationType::UN_APPROVED) {
                DB::rollback();
                return response()->json(['message' => "This reservation has not been approved yet, and you cannot confirm it."], 500);
            }
            $existReservationHistory = ReservationHistory::where('reservation_id', $reservation->id)->first();

            if (!$existReservationHistory) {
                $reservation_history = new ReservationHistory();
                $reservation_history->reservation_id = $reservation->id;
                $reservation_history->expert_id = $reservation->expert_id;
                $reservation_history->client_id = $reservation->client_id;
                $reservation_history->is_confirmed = ConfirmedType::CONFIRMED;
                $reservation_history->date = $reservation->date;
                $reservation_history->start_time = $reservation->start_time;
                $reservation_history->end_time = $reservation->end_time;
                $reservation_history->status = $reservation->status;
                $reservation_history->arrive_time = Carbon::now();
                $reservation_history->arrive_date = date('Y-m-d');
                $reservation_history->save();
                DB::commit();
                return response()->json(['message' => "Reservation Confirmed Successfully."], 200);
            } elseif ($existReservationHistory && $existReservationHistory->is_confirmed == ConfirmedType::UN_CONFIRMED) {
                $existReservationHistory->update([
                    'is_confirmed' => ConfirmedType::CONFIRMED
                ]);
                DB::commit();
                return response()->json(['message' => "Reservation Confirmed Successfully."], 200);
            } elseif ($existReservationHistory && $existReservationHistory->is_confirmed == ConfirmedType::CONFIRMED) {
                $existReservationHistory->update([
                    'is_confirmed' => ConfirmedType::UN_CONFIRMED
                ]);
                DB::commit();
                return response()->json(['message' => "Reservation Unconfirmed Successfully."], 200);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['message' => "Reservation Confirmed Failed."], 500);
        }
    }
}
