<?php

namespace App\Http\Controllers\Api;

use App\ApiHelper\ApiResponseHelper;
use App\ApiHelper\Result;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateClientRequest;
use App\Http\Requests\Rservation\CancleReservationRequest;
use App\Http\Requests\Rservation\CompleteReservationRequest;
use App\Http\Requests\Rservation\CreateReservationRequest;
use App\Http\Requests\Rservation\DelayReservationRequest;
use App\Http\Requests\Rservation\GetReservationRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Http\Requests\Users\GetClientsRequest;
use App\Http\Resources\Rservation\ReservationResource;
use App\Http\Resources\Users\ClientResource;
use App\Services\Receiption\ReceiptionService;

class ReceiptionController extends Controller
{
    public function __construct(private ReceiptionService $receiptionService)
    {
    }
    public function create_client(CreateClientRequest $request)
    {
        $createdData = $this->receiptionService->create_client($request->validated());

        $returnData = ClientResource::make($createdData);

        return ApiResponseHelper::sendResponse(
            new Result($returnData, "Done")
        );
    }

    public function get_reservation($id)
    {
        $reservationData = $this->receiptionService->get_reservation($id);
        $returnData = ReservationResource::make($reservationData);
        return ApiResponseHelper::sendResponse(
            new Result($returnData,  "DONE")
        );
    }
    public function create_reservation(CreateReservationRequest $request)
    {
        $createdData = $this->receiptionService->create_reservation($request->validated());

        if (is_string($createdData)) {
            return response()->json(['message' => $createdData]);
        } else {
            $returnData = ReservationResource::make($createdData);
            return ApiResponseHelper::sendResponse(
                new Result($returnData, "Done")
            );
        }
    }

    public function complete_reservation(CompleteReservationRequest $request)
    {
        $createdData = $this->receiptionService->complete_reservation($request->validated());
        $returnData = ReservationResource::make($createdData);
        return ApiResponseHelper::sendResponse(
            new Result($returnData, "Done")
        );
    }
    public function cancle_reservation(CancleReservationRequest $request)
    {

        $createdData = $this->receiptionService->cancle_reservation($request->validated());
        $returnData = ReservationResource::make($createdData);
        return ApiResponseHelper::sendResponse(
            new Result($returnData, "Done")
        );
    }
    public function delay_reservation(DelayReservationRequest $request)
    {

        $createdData = $this->receiptionService->delay_reservation($request->validated());
        if (is_string($createdData)) {
            return response()->json(['message' => $createdData]);
        } else {
            $returnData = ReservationResource::make($createdData);
            return ApiResponseHelper::sendResponse(
                new Result($returnData, "Done")
            );
        }
    }

    public function client_reservations(GetReservationRequest $request)
    {
        $data = $this->receiptionService->client_reservations($request->generateFilter());
        $returnData = ReservationResource::collection($data);
        return ApiResponseHelper::sendResponse(
            new Result($returnData, "Done")
        );
    }

    public function list_of_client(GetClientsRequest $request)

    {
        $data = $this->receiptionService->list_of_client($request->generateFilter());
        $returnData = ClientResource::collection($data);
        return ApiResponseHelper::sendResponse(
            new Result($returnData, "Done")
        );
    }

    public function update_client(UpdateClientRequest $request)
    {
        $data = $this->receiptionService->update_client($request->validated());
        $returnData = ClientResource::make($data);
        return ApiResponseHelper::sendResponse(
            new Result($returnData, "Done")
        );
    }
}
