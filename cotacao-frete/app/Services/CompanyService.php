<?php

namespace App\Services;

use App\Exceptions\ServiceException;
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
    public function createCompanyIfNotExists(array $companyData)
    {

        try {
            $checkExistsCompany = $this->repository->searchBy('registered_number', $companyData['registered_number']);
            if ($checkExistsCompany->isEmpty()) {
                return $this->create($companyData);
            }
            return false;
        } catch (\Exception $e) {
            throw new ServiceException("Erro: {$e->getMessage()}", 500);
        }
    }

    /**
     * @param int $limit
     * @return mixed
     * @throws ServiceException
     */
    public function lastQuotes(int $limit = 50) {
        try {
            return $this->repository->metrics($limit);
        } catch (\Exception $e) {
            throw new ServiceException("Erro: {$e->getMessage()}", 500);
        }
    }
}
