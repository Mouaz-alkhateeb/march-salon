<?php

namespace App\Http\Controllers\Api;

use App\ApiHelper\ApiResponseHelper;
use App\ApiHelper\Result;
use App\Http\Controllers\Controller;
use App\Http\Requests\BridePackage\CreateBridePackageRequest;
use App\Http\Requests\BridePackage\GetBridePackageListRequest;
use App\Http\Requests\BridePackage\UpdateBridePackageRequest;
use App\Http\Resources\BridePackage\BridePackageResource;
use App\Services\BridePackage\BridePackageService;
use Illuminate\Http\Request;

class BridePackageController extends Controller
{
    public function __construct(private BridePackageService $bridePackageService)
    {
    }
    public function create_bride_package(CreateBridePackageRequest $request)
    {
        $createdData = $this->bridePackageService->create_bride_package($request->validated());
        if ($createdData['success']) {
            $returnData = BridePackageResource::make($createdData['data']);

            return ApiResponseHelper::sendResponse(
                new Result($returnData, "Done")
            );
        } else {
            return ApiResponseHelper::sendFailedResponse($createdData['message'], $createdData['code']);
        }
    }

    public function update_bride_package(UpdateBridePackageRequest $request)
    {

        $createdData = $this->bridePackageService->update_bride_package($request->validated());
        if ($createdData['success']) {
            $returnData = BridePackageResource::make($createdData['data']);

            return ApiResponseHelper::sendResponse(
                new Result($returnData, "Done")
            );
        } else {
            return ApiResponseHelper::sendFailedResponse($createdData['message'], $createdData['code']);
        }
    }

    public function delete_bride_package($id)
    {
        $deletionResult = $this->bridePackageService->delete_bride_package($id);

        if ($deletionResult) {
            return $deletionResult;
        } else {
            return response()->json(['message' => 'Error Deleting Bride Package,Please Try Again'], 500);
        }
    }

    public function get_bride_packages_list(GetBridePackageListRequest $request)
    {
        $data = $this->bridePackageService->get_bride_packages_list($request->generateFilter());
        $returnData = BridePackageResource::collection($data);
        return ApiResponseHelper::sendResponse(
            new Result($returnData, "DONE")
        );
    }
    public function show($id)
    {
        $createdData = $this->bridePackageService->show($id);

        $returnData = BridePackageResource::make($createdData);

        return ApiResponseHelper::sendResponse(
            new Result($returnData, "Done")
        );
    }
}
