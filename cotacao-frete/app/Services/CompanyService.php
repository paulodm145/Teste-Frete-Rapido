<?php

namespace App\Services;

use App\Repositories\CompanyRepository;

class CompanyService extends BaseService
{
    public function __construct(CompanyRepository $companyRepository)
    {
        parent::__construct($companyRepository);
    }

    /**
     * @param array $companyData
     * @return mixed
     */
    public function createMultipliesCompanies(array $companyData) {

        $checkExistsCompany = $this->repository->searchBy('registered_number', $companyData['registered_number']);

        if($checkExistsCompany->isEmpty()) {
            return $this->repository->create($companyData);
        }

        return false;
    }
}
