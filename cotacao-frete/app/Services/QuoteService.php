<?php

namespace App\Services;

use App\Exceptions\ServiceException;
use App\Repositories\QuoteRepository;
use mysql_xdevapi\Collection;

class QuoteService extends BaseService
{
    private $integrationFreteRapidoAPIService;

    private $companyService;

    private $serviceService;

    public function __construct(
        IntegrationFreteRapidoAPIService $integrationFreteRapidoAPIService,
        CompanyService $companyService,
        ServiceService $serviceService,
        QuoteRepository $quoteRepository
    )
    {
        $this->integrationFreteRapidoAPIService = $integrationFreteRapidoAPIService;
        $this->companyService = $companyService;
        $this->serviceService = $serviceService;
        parent::__construct($quoteRepository);
    }

    /**
     * @param array $dataQuote
     * @return array
     * @throws ServiceException
     */
    public function quote(array $dataQuote)
    {
        try {
            $offers = $this->integrationFreteRapidoAPIService->quote($dataQuote)['dispatchers'][0]['offers'];

            $offersList = [];

            foreach ($offers as $offer) {
                $offersList[] = [
                    "name" => $offer['carrier']['name'],
                    "service" => $offer['service'],
                    "deadline" => $offer['carrier']['name'],
                    "price" => $offer['final_price'],
                ];

                $this->createCompanie([
                    "name" => $offer['carrier']['name'],
                    "registered_number" => $offer['carrier']['registered_number'],
                ]);

                $this->createService($offer['carrier']['registered_number'], $offer['service']);

                $this->createQuote($offer['carrier']['registered_number'], $offer['service'], (float)$offer['final_price']);


            }

            return $offersList;

        } catch (\Exception $e) {
            throw new ServiceException("Erro: {$e->getMessage()}", 500);
        }
    }

    /**
     * @param array $dataCompany
     * @return false|mixed
     * @throws ServiceException
     */
    public function createCompanie(array $dataCompany)
    {
        try {

            return $this->companyService->createCompanyIfNotExists([
                "name" => $dataCompany['name'],
                "registered_number" => $dataCompany['registered_number'],
            ]);

        } catch (\Exception $e) {
            throw new ServiceException("Erro: {$e->getMessage()}", 500);
        }
    }

    /**
     * @param string $registeredNumber
     * @param string $serviceDescription
     * @return mixed
     * @throws ServiceException
     */
    public function createService(string $registeredNumber, string $serviceDescription)
    {

        try {

            $service = $this->serviceService->getServiceByRegisteredNumberAndDescription($registeredNumber, $serviceDescription);

            $company = $this->companyService->searchBy('registered_number', $registeredNumber)->first();

            if (!$service) {
                $this->serviceService->create([
                    "company_id" => $company->id,
                    "description" => $serviceDescription,
                ]);
            }

            return $service;

        } catch (\Exception $e) {
            throw new ServiceException("Erro: {$e->getMessage()}", 500);
        }
    }

    /**
     * @param string $registeredNumber
     * @param string $serviceDescription
     * @param float $price
     * @return mixed
     * @throws ServiceException
     */
    public function createQuote(string $registeredNumber, string $serviceDescription, float $price)
    {
        try {
            $serviceId = $this->serviceService
                ->getServiceByRegisteredNumberAndDescription($registeredNumber, $serviceDescription)
                ->service_id;

            return $this->repository->create([
                "service_id" => $serviceId,
                "price" => $price,
            ]);

        } catch (\Exception $e) {
            throw new ServiceException("Erro: {$e->getMessage()}", 500);
        }
    }

}
