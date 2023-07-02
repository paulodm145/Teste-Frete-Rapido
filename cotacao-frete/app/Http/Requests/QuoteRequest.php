<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "recipient.address.zipcode" => "required|string|min:8|max:8",
            "volumes.*.category" => "required|integer",
            "volumes.*.amount" => "required|integer|min:1",
            "volumes.*.unitary_weight" => "required|numeric|min:0",
            "volumes.*.price" => "required|numeric|min:0",
            "volumes.*.sku" => "required|string",
            "volumes.*.height" => "required|numeric|min:0",
            "volumes.*.width" => "required|numeric|min:0",
            "volumes.*.length" => "required|numeric|min:0"
        ];
    }
}
