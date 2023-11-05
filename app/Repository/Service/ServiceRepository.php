<?php

namespace App\Repository\Service;

use App\Filter\Service\ServiceFilter;
use App\Models\Service;
use App\Repository\BaseRepositoryImplementation;
use Illuminate\Support\Facades\DB;

class ServiceRepository extends BaseRepositoryImplementation
{
    public function getFilterItems($filter)
    {
        $records = Service::query();
        if ($filter instanceof ServiceFilter) {

            return $records->get();
        }
        return $records->get();
    }

    public function create_service($data)
    {
        DB::beginTransaction();
        try {
            $exixtService = Service::where('name', $data['name'])->first();
            if ($exixtService) {
                return ['success' => false, 'message' => "Service Has Been Already Exists", 'code' => 500];
            }
            $service = new Service();
            $service->name = $data['name'];
            $service->save();
            DB::commit();

            return ['success' => true, 'data' => $service, 'code' => 200];
        } catch (\Exception $e) {
            DB::rollback();
            return ['success' => false, 'message' => "Service not created,Please Try Again", 'code' => 500];
        }
    }

    public function update_service($data)
    {
        DB::beginTransaction();
        try {
            $service = Service::findOrFail($data['service_id']);

            if (isset($data['name'])) {
                $service->name = $data['name'];
            }
            $service->save();
            DB::commit();
            return ['success' => true, 'data' =>   $service, 'code' => 200];
        } catch (\Exception $e) {

            DB::rollback();
            return ['success' => false, 'message' => "Service not updated,Please Try Again", 'code' => 500];
        }
    }

    public function delete_service(int $id)
    {
        $service = Service::where('id', $id)->first();

        if ($service) {
            $service->delete();
            return response()->json(['message' => 'Service Delete Successfully'], 200);
        } else {
            return response()->json(['message' => 'Service Not Found'], 404);
        }
    }


    public function model()
    {
        return Service::class;
    }
}
