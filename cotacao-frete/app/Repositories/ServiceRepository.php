<?php

namespace App\Repositories;

use App\Models\Service;

class ServiceRepository extends BaseRepository
{
    public function __construct(Service $model)
    {
        parent::__construct($model);
    }

    public function getServiceByRegisteredNumberAndDescription($registeredNumber, $description)
    {
        return $this->model->query()->join('companies', 'companies.id', '=', 'services.company_id')
            ->where('companies.registered_number', '=', $registeredNumber)
            ->where('services.description', '=',$description)->first();
    }
}
