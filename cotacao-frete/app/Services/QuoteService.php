<?php

namespace App\Services;

use App\Repositories\QuoteRepository;

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

                $idCompany = $this->createCompanie([
                    "name" => $offer['carrier']['name'],
                    "registered_number" => $offer['carrier']['registered_number'],
                ])->id;

                $serviceCompany = $this->serviceService->getServiceByRegisteredNumberAndDescription($offer['carrier']['registered_number'], $offer['service']);
                if($serviceCompany->isEmpty()) {
                    $this->serviceService->create([
                        "description" => $offer['service'],
                        "company_id" => $idCompany,
                    ]);
                }
            }

            return $offersList;

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function createCompanie(array $dataCompany) {
        return $this->companyService->createMultipliesCompanies([
            "name" => $dataCompany['name'],
            "registered_number" => $dataCompany['registered_number'],
        ]);
    }



}
