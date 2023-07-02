<?php

namespace App\Services;

class QuoteService
{
    private $integrationFreteRapidoAPIService;

    public function __construct(IntegrationFreteRapidoAPIService $integrationFreteRapidoAPIService)
    {
        $this->integrationFreteRapidoAPIService = $integrationFreteRapidoAPIService;
    }

    public function Simulate()
    {
        return $this->integrationFreteRapidoAPIService->Simulate();
    }

}
