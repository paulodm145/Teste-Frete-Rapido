<?php

namespace App\Services;

class QuoteService
{
    private $integrationFreteRapidoAPIService;

    public function __construct(IntegrationFreteRapidoAPIService $integrationFreteRapidoAPIService)
    {
        $this->integrationFreteRapidoAPIService = $integrationFreteRapidoAPIService;
    }

    public function Simulate(array $data)
    {
        $offers = $this->integrationFreteRapidoAPIService->Simulate($data)['dispatchers'][0]['offers'];

        $offersList = [];
        foreach ($offers as $offer) {
            $offersList[] = [
                "name"     => $offer['carrier']['name'],
                "service"  => $offer['service'],
                "deadline" => $offer['carrier']['name'],
                "price"    => $offer['final_price'],
            ];
        }

        return $offersList;
    }

}
