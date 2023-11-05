<?php

namespace App\Http\Controllers\Api;

use App\ApiHelper\ApiResponseHelper;
use App\ApiHelper\Result;
use App\Http\Controllers\Controller;
use App\Http\Requests\Service\CreateServiceRequest;
use App\Http\Requests\Service\GetServicesRequest;
use App\Http\Requests\Service\UpdateServiceRequest;
use App\Http\Resources\Service\ServiceResource;
use App\Services\Service\ServiceService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function __construct(private ServiceService $serviceService)
    {
    }
    public function create_service(CreateServiceRequest $request)
    {
        $createdData = $this->serviceService->create_service($request->validated());
        if ($createdData['success']) {
            $returnData = ServiceResource::make($createdData['data']);

            return ApiResponseHelper::sendResponse(
                new Result($returnData, "Done")
            );
        } else {
            return ApiResponseHelper::sendFailedResponse($createdData['message'], $createdData['code']);
        }
    }

    public function update_service(UpdateServiceRequest $request)
    {

        $createdData = $this->serviceService->update_service($request->validated());
        if ($createdData['success']) {
            $returnData = ServiceResource::make($createdData['data']);

            return ApiResponseHelper::sendResponse(
                new Result($returnData, "Done")
            );
        } else {
            return ApiResponseHelper::sendFailedResponse($createdData['message'], $createdData['code']);
        }
    }

    public function delete_service($id)
    {
        $deletionResult = $this->serviceService->delete_service($id);

        if ($deletionResult) {
            return $deletionResult;
        } else {
            return response()->json(['message' => 'Error Deleting Service,Please Try Again'], 500);
        }
    }

    public function get_services_list(GetServicesRequest $request)
    {
        $data = $this->serviceService->get_services_list($request->generateFilter());
        $returnData = ServiceResource::collection($data);
        return ApiResponseHelper::sendResponse(
            new Result($returnData, "DONE")
        );
    }
    public function show($id)
    {
        $createdData = $this->serviceService->show($id);

        $returnData = ServiceResource::make($createdData);

        return ApiResponseHelper::sendResponse(
            new Result($returnData, "Done")
        );
    }
}
