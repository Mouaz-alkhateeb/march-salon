<?php

namespace App\Interfaces\BridePackage;

use App\Filter\BridePackege\BridePackegeFilter;

interface BridePackageServiceInterface
{
    public function create_bride_package($data);
    public function update_bride_package($data);
    public function delete_bride_package(int $id);
    public function get_bride_packages_list(BridePackegeFilter $bridePackegeFilter = null);
}
