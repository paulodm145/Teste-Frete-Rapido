<?php

namespace App\Repositories;

use App\Exceptions\ServiceException;
use App\Models\Service;
use Illuminate\Database\QueryException;

class ServiceRepository extends BaseRepository
{
    public function __construct(Service $model)
    {
        parent::__construct($model);
    }

    /**
     * @param $registeredNumber
     * @param $description
     * @return mixed
     * @throws ServiceException
     */
    public function getServiceByRegisteredNumberAndDescription($registeredNumber, $description)
    {
        try {
            return $this->model->join('companies', 'companies.id', '=', 'services.company_id')
                ->where('companies.registered_number', '=', $registeredNumber)
                ->where('services.description', '=', $description)->first([
                    'services.id as service_id',
                    'services.description',
                    'services.company_id',
                    'companies.registered_number',
                    'companies.name'
                ]);
        } catch (QueryException $e) {
            return throw new ServiceException("Erro: {$e->getMessage()}", 500);
        }
    }
}
