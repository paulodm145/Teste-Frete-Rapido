<?php

namespace App\Http\Controllers;

use App\Services\QuoteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuoteController extends Controller
{

    private $quoteService;

    public function __construct(QuoteService $quoteService)
    {
        $this->quoteService = $quoteService;
    }

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

        return response($this->quoteService->quote($request->all()), 200);

    }
}
