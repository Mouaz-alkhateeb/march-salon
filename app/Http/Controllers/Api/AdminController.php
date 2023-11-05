<?php

namespace App\Http\Controllers\Api;

use App\ApiHelper\ApiResponseHelper;
use App\ApiHelper\Result;
use App\Events\NotificationEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Expert\CreateExpertRequest;
use App\Http\Requests\Expert\GetExpertsRequest;
use App\Http\Requests\Expert\UpdateExpertRequest;
use App\Http\Requests\Holiday\CreateHolidayRequest;
use App\Http\Requests\Receiption\UpdateReceiptionRequest;
use App\Http\Requests\Rservation\ReservationHistoryListRequest;
use App\Http\Requests\Service\CreateServiceRequest;
use App\Http\Requests\Service\GetServicesRequest;
use App\Http\Requests\Transfer\CreateTransferRequest;
use App\Http\Requests\Transfer\GetTransfersRequest;
use App\Http\Requests\Transfer\UpdateransferRequest;
use App\Http\Requests\Users\ChangePermissionRequest;
use App\Http\Requests\Users\CreateUserRequest;
use App\Http\Requests\Users\GetClientsFilterDateRequest;
use App\Http\Requests\Users\GetReceiptionsRequest;
use App\Http\Resources\Admin\AdminDataResource;
use App\Http\Resources\Expert\ExpertResource;
use App\Http\Resources\Holiday\HolidayResource;
use App\Http\Resources\NotificationResource;
use App\Http\Resources\Receiption\ReceiptionResource;
use App\Http\Resources\Rservation\ReservationHistory;
use App\Http\Resources\Service\ServiceResource;
use App\Http\Resources\Transfer\TransferResource;
use App\Http\Resources\Users\UserResource;
use App\Models\Client;
use App\Models\Expert;
use App\Models\Notification;
use App\Models\Reservation;
use App\Services\Admin\AdminService;
use PDF;


class AdminController extends Controller
{
    public function __construct(private AdminService $adminService)
    {
    }
    public function create_admin(CreateUserRequest $request)
    {
        $createdData = $this->adminService->create_admin($request->validated());

        $returnData = UserResource::make($createdData);
        return ApiResponseHelper::sendResponse(
            new Result($returnData, "Done")
        );
    }
    public function create_receiption(CreateUserRequest $request)
    {
        $createdData = $this->adminService->create_receiption($request->validated());

        $returnData = UserResource::make($createdData);
        return ApiResponseHelper::sendResponse(
            new Result($returnData, "Done")
        );
    }

    public function delete_client(Client $client)
    {
        try {
            $client->delete();
            return response([
                'message' => 'client deleted successfully'
            ], 200);
        } catch (\Throwable $th) {
            return response([
                'message' => $th->getMessage()
            ], 500);
        }
    }


    public function delete_notification(Notification $notification)
    {
        try {
            $notification->delete();
            return response([
                'message' => 'client deleted successfully'
            ], 200);
        } catch (\Throwable $th) {
            return response([
                'message' => $th->getMessage()
            ], 500);
        }
    }


    public function get_all_notifications()
    {
        $notifications = Notification::orderBy('id', 'desc')->get();

        return response([
            "data" => NotificationResource::collection($notifications)
        ], 200);
    }

    public function create_transfer(CreateTransferRequest $request)
    {
        $createdData = $this->adminService->create_transfer($request->validated());

        $returnData = TransferResource::make($createdData);
        return ApiResponseHelper::sendResponse(
            new Result($returnData, "Done")
        );
    }

    public function delete_reservation(Reservation $reservation)
    {
        try {
            $reservation->delete();
            return response([
                'message' => 'reservation deleted successfully'
            ], 200);
        } catch (\Throwable $th) {
            return response([
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function show_transfer($id)
    {
        $employeeData = $this->adminService->show_transfer($id);
        $returnData = TransferResource::make($employeeData);
        return ApiResponseHelper::sendResponse(
            new Result($returnData,  "DONE")
        );
    }

    public function update_transfer(UpdateransferRequest $request)
    {
        $createdData = $this->adminService->update_transfer($request->validated());

        $returnData = TransferResource::make($createdData);
        return ApiResponseHelper::sendResponse(
            new Result($returnData, "Done")
        );
    }

    public function delete_transfer($id)
    {
        $deletionResult = $this->adminService->delete_transfer($id);

        if ($deletionResult) {
            return $deletionResult;
        } else {
            return response()->json(['message' => 'Error Deleting Transfer,Please Try Again'], 500);
        }
    }
    public function update_receiption(UpdateReceiptionRequest $request)
    {
        $createdData = $this->adminService->update_receiption($request->validated());

        $returnData = UserResource::make($createdData);
        return ApiResponseHelper::sendResponse(
            new Result($returnData, "Done")
        );
    }



    public function list_of_transfers(GetTransfersRequest $request)
    {
        $data = $this->adminService->list_of_transfers($request->generateFilter());
        $returnData = TransferResource::collection($data);
        return ApiResponseHelper::sendResponse(
            new Result($returnData, "DONE")
        );
    }

    public function delete_expert(Expert $expert)
    {
        try {
            $expert->delete();
            return response([
                'message' => 'expert deleted successfully'
            ], 200);
        } catch (\Throwable $th) {
            return response([
                'message' => $th->getMessage()
            ], 500);
        }
    }


    public function delete_receiption($id)
    {
        $deletionResult = $this->adminService->delete_receiption($id);

        if ($deletionResult) {
            return $deletionResult;
        } else {
            return response()->json(['message' => 'Error Deleting Receiption,Please Try Again'], 500);
        }
    }

    public function create_expert(CreateExpertRequest $request)
    {
        $createdData = $this->adminService->create_expert($request->validated());
        $returnData = ExpertResource::make($createdData);
        return ApiResponseHelper::sendResponse(
            new Result($returnData, "Done")
        );
    }

    public function list_of_experts(GetExpertsRequest $request)
    {
        $data = $this->adminService->list_of_experts($request->generateFilter());
        $returnData = ExpertResource::collection($data);
        return ApiResponseHelper::sendResponse(
            new Result($returnData,  "DONE")
        );
    }

    public function list_of_receiptions(GetReceiptionsRequest $request)
    {
        $data = $this->adminService->list_of_receiptions($request->generateFilter());
        $returnData = UserResource::collection($data);

        return ApiResponseHelper::sendResponse(
            new Result($returnData, "DONE")
        );
    }

    public function create_holiday(CreateHolidayRequest $request)
    {
        $createdData = $this->adminService->create_holiday($request->validated());
        if ($createdData == null) {
            return response()->json(['message' => 'Holiday Deleted']);
        } else {
            $returnData = HolidayResource::make($createdData);
        }
        return ApiResponseHelper::sendResponse(
            new Result($returnData, "Done")
        );
    }
    public function chang_permission(ChangePermissionRequest $request)
    {
        $updatedUser = $this->adminService->chang_permission($request->validated());

        if (is_object($updatedUser)) {
            return response()->json(['message' => 'Receiption ' . $updatedUser->name . ' Permission Updated Successfully']);
        } elseif ($updatedUser == 'Failed') {
            return response()->json(['message' => 'You Cannot Change Permission For This User']);
        }
        return ApiResponseHelper::sendResponse(
            new Result("Done")
        );
    }

    public function most_active_client()
    {
        $data = $this->adminService->most_active_client();
        $returnData = AdminDataResource::make($data);
        return ApiResponseHelper::sendResponse(
            new Result($returnData, "DONE")
        );
    }

    public function number_daily_clients(GetClientsFilterDateRequest $request)
    {
        $data = $this->adminService->number_daily_clients($request->generateFilter());
        return $data;
    }


    public function update_expert(UpdateExpertRequest $request)
    {
        $data = $this->adminService->update_expert($request->validated());
        $returnData = ExpertResource::make($data);
        return ApiResponseHelper::sendResponse(
            new Result($returnData, "Done")
        );
    }

    public function confirm_reservation($id)
    {
        $result = $this->adminService->confirm_reservation($id);
        return $result;
    }

    public function reservations_history(ReservationHistoryListRequest $request)
    {
        $data = $this->adminService->reservations_history($request->generateFilter());
        $returnData = ReservationHistory::collection($data);
        return ApiResponseHelper::sendResponse(
            new Result($returnData, "DONE")
        );
    }

    public function export(GetTransfersRequest $request)
    {
        return $this->adminService->export($request->generateFilesFilter());
    }
    public function export_pdf(GetTransfersRequest $request)
    {
        return $this->adminService->export_pdf($request->generateFilesFilter());
    }
}
