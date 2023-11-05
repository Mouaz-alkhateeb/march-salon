<?php

namespace App\Services\BridePackage;

use App\Filter\BridePackege\BridePackegeFilter;
use App\Interfaces\BridePackage\BridePackageServiceInterface;
use App\Repository\BridePackage\BridePackageReposirory;

class BridePackageService implements BridePackageServiceInterface
{
    public function __construct(private BridePackageReposirory $bridePackageReposirory)
    {
    }

    public function create_bride_package($data)
    {
        return $this->bridePackageReposirory->create_bride_package($data);
    }

    public function update_bride_package($data)
    {
        return $this->bridePackageReposirory->update_bride_package($data);
    }

    public function delete_bride_package(int $id)
    {
        return $this->bridePackageReposirory->delete_bride_package($id);
    }

    public function get_bride_packages_list(BridePackegeFilter $bridePackegeFilter = null)
    {
        if ($bridePackegeFilter != null)
            return $this->bridePackageReposirory->getFilterItems($bridePackegeFilter);
        else
            return $this->bridePackageReposirory->get();
    }
    public function show(int $id)
    {
        return $this->bridePackageReposirory->getById($id);
    }
}
