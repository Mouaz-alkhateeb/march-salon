<?php

namespace App\Interfaces\Service;

use App\Filter\Service\ServiceFilter;

interface ServiceServiceInterface
{
    public function create_service($data);
    public function update_service($data);
    public function delete_service(int $id);
    public function get_services_list(ServiceFilter $serviceFilter = null);
}
