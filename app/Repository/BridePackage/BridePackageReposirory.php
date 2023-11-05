<?php

namespace App\Repository\BridePackage;

use App\Filter\BridePackege\BridePackegeFilter;
use App\Models\BridePackage;
use App\Repository\BaseRepositoryImplementation;
use Illuminate\Support\Facades\DB;

class BridePackageReposirory extends BaseRepositoryImplementation
{
    public function getFilterItems($filter)
    {
        $records = BridePackage::query();
        if ($filter instanceof BridePackegeFilter) {

            return $records->get();
        }
        return $records->get();
    }

    public function create_bride_package($data)
    {
        DB::beginTransaction();
        try {
            $exixtBridePackage = BridePackage::where('name', $data['name'])->first();
            if ($exixtBridePackage) {
                return ['success' => false, 'message' => "Bride Package Has Been Already Exists", 'code' => 500];
            }
            $bride_package = new BridePackage();
            $bride_package->name = $data['name'];
            $bride_package->save();
            DB::commit();

            return ['success' => true, 'data' => $bride_package, 'code' => 200];
        } catch (\Exception $e) {
            DB::rollback();
            return ['success' => false, 'message' => "Bride Package not created,Please Try Again", 'code' => 500];
        }
    }

    public function update_bride_package($data)
    {
        DB::beginTransaction();
        try {
            $bride_package = BridePackage::findOrFail($data['bride_package_id']);

            if (isset($data['name'])) {
                $bride_package->name = $data['name'];
            }
            $bride_package->save();

            DB::commit();

            return ['success' => true, 'data' =>   $bride_package, 'code' => 200];
        } catch (\Exception $e) {

            DB::rollback();
            return ['success' => false, 'message' => "Bride Package not updated,Please Try Again", 'code' => 500];
        }
    }


    public function delete_bride_package(int $id)
    {
        $this->deleteById($id);
        return response()->json(['message' => 'Bride Package Delete Successfully'], 200);
    }


    public function model()
    {
        return BridePackage::class;
    }
}
