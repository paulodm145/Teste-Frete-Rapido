<?php

namespace App\Http\Controllers;

use App\Services\IntegrationFreteRapidoAPIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;


class QuoteController extends Controller
{
    public function quote(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                "recipient.address.zipcode" => "required|string|min:8|max:8",
                "volumes.*.category" => "required|integer",
                "volumes.*.amount" => "required|integer|min:1",
                "volumes.*.unitary_weight" => "required|numeric|min:0",
                "volumes.*.price" => "required|numeric|min:0",
                "volumes.*.sku" => "required|string",
                "volumes.*.height" => "required|numeric|min:0",
                "volumes.*.width" => "required|numeric|min:0",
                "volumes.*.length" => "required|numeric|min:0"
            ]
        );

        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }


        $array = [
            "shipper" => [
                "registered_number" => "25438296000158",
                "token" => "1d52a9b6b78cf07b08586152459a5c90",
                "platform_code" => "5AKVkHqCn"
            ],
            "recipient" => [
                "type" => 0,
                "registered_number" => "",
                "state_inscription" => "",
                "country" => "BRA",
                "zipcode" => $request->recipient["address"]["zipcode"] + 0
            ],
            "dispatchers" => [
                [
                    "registered_number" => "25438296000158",
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
//
        //$response = Http::post('https://sp.freterapido.com/api/v3/quote/simulate', $array);
        $response = (new IntegrationFreteRapidoAPIService())->Simulate();

        return $response;
    }
}
