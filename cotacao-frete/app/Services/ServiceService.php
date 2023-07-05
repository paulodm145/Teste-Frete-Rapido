<?php

namespace App\Services;

use App\Repositories\ServiceRepository;

class ServiceService extends BaseService
{
    public function __construct(ServiceRepository $serviceRepository)
    {
        parent::__construct($serviceRepository);
    }

    public function getServiceByRegisteredNumberAndDescription($registeredNumber, $description)
    {
        return $this->repository->getServiceByRegisteredNumberAndDescription($registeredNumber, $description);
    }


}
