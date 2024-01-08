<?php

namespace App\Http\Requests\User\ContractOffers;

use App\Http\Requests\FormRequest;

class CreateContractOfferRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "dad_id" => "required",
            "date_start" => "required|date_format:Y-m-d H:i:s",
            "date_end" => "required|date_format:Y-m-d H:i:s",
            "selling_price" => "required",
            "dad_percent" => "required",
            "artist_percent" => "required",
        ];
    }
}
