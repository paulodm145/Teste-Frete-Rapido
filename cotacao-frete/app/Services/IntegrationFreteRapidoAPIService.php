<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class IntegrationFreteRapidoAPIService
{

    const URL = "https://sp.freterapido.com/api/v3";
    const TOKEN = "1d52a9b6b78cf07b08586152459a5c90";
    const PLATFORM_CODE = "5AKVkHqCn";
    const REGISTERED_NUMBER = "25438296000158";

    /**
     * @return Response|string
     */
    public function Simulate()
    {
        try {

            $dataQuote = [
                "shipper" => [
                    "registered_number" => self::REGISTERED_NUMBER,
                    "token" => self::TOKEN,
                    "platform_code" => self::PLATFORM_CODE
                ],
                "recipient" => [
                    "type" => 0,
                    "registered_number" => self::REGISTERED_NUMBER,
                    "state_inscription" => "",
                    "country" => "BRA",
                    "zipcode" => 1311000
                ],
                "dispatchers" => [
                    [
                        "registered_number" => self::REGISTERED_NUMBER,
                        "zipcode" => 29161376,
                        "total_price" => 0.0,
                        "volumes" => [
                            [
                                "amount" => 1,  //Já tenho
                                "amount_volumes" => 1,  //Já tenho
                                "category" => "7", //Já tenho
                                "sku" => "abc-teste-527",  //Já tenho
                                "tag" => "ABCTESTE",
                                "description" => "ABC TESTE",
                                "height" => 0.2,  //Já tenho
                                "width" => 0.2,  //Já tenho
                                "length" => 0.2,  //Já tenho
                                "unitary_price" => 500,
                                "unitary_weight" => 4, //Já tenho
                                "consolidate" => false,
                                "overlaid" => false,
                                "rotate" => false
                            ]
                        ]
                    ]
                ],
                "channel" => "",
                "filter" => 0,
                "limit" => 0,
                "identification" => "",
                "reverse" => false,
                "simulation_type" => [0],
                "returns" => [
                    "composition" => false,
                    "volumes" => false,
                    "applied_rules" => false
                ]
            ];

            return Http::post(self::URL . '/quote/simulate', $dataQuote);

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


}
