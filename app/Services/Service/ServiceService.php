<?php

namespace App\Services\Service;

use App\Filter\Service\ServiceFilter;
use App\Interfaces\Service\ServiceServiceInterface;
use App\Repository\Service\ServiceRepository;

class ServiceService implements ServiceServiceInterface
{
    public function __construct(private ServiceRepository $serviceRepository)
    {
    }

    public function create_service($data)
    {
        return $this->serviceRepository->create_service($data);
    }

    public function update_service($data)
    {
        return $this->serviceRepository->update_service($data);
    }

    public function delete_service(int $id)
    {
        return $this->serviceRepository->delete_service($id);
    }

    public function get_services_list(ServiceFilter $serviceFilter = null)
    {
        if ($serviceFilter != null)
            return $this->serviceRepository->getFilterItems($serviceFilter);
        else
            return $this->serviceRepository->get();
    }

    public function show(int $id)
    {
        return $this->serviceRepository->getById($id);
    }
}
