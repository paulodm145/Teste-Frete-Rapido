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
    const ZIP_CODE = 29161376;


    /**
     * @param array $data
     * @return array|string
     */
    public function quote(array $data)
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
                    "zipcode" => $data["recipient"]["address"]["zipcode"] + 0,
                ],
                "dispatchers" => [
                    [
                        "registered_number" => self::REGISTERED_NUMBER,
                        "zipcode" => self::ZIP_CODE,
                        "total_price" => 0.0,
                        "volumes" => $this->buildVolumes($data["volumes"])
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

    /**
     * @param array $volumes
     * @return array
     */
    private function buildVolumes(array $volumes) : array
    {
        $volumesList = [];
        foreach($volumes as $volume) {
            $volumesList[] = [
                "amount"            => $volume["amount"],
                "amount_volumes"    => 1,
                "category"          => (string)$volume["category"],
                "sku"               => $volume["sku"],
                "tag"               => array_key_exists('tag', $volume) ? $volume["tag"] : "",
                "description"       => array_key_exists('description', $volume) ? $volume["tag"] : "",
                "height"            => $volume["height"],
                "width"             => $volume["width"],
                "length"            => $volume["length"],
                "unitary_price"     => $volume["price"],
                "unitary_weight"    => $volume["unitary_weight"],
                "consolidate"       => array_key_exists('consolidate', $volume) ? $volume["tag"] : false,
                "overlaid"          => array_key_exists('overlaid', $volume) ? $volume["tag"] : false,
                "rotate"            => array_key_exists('rotate', $volume) ? $volume["tag"] : false
            ];
        }
        return $volumesList;
    }


}
