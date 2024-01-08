<?php

namespace App\Http\Requests\Admin\ContractOffers;

use App\Http\Requests\FormRequest;

class CreateContractOfferRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "id" => "required",
            "created_at" => "required|date_format:Y-m-d H:i:s",
            "updated_at" => "required|date_format:Y-m-d H:i:s",
            "dad_id" => "required",
            "artist_id" => "required",
            "date_start" => "required|date_format:Y-m-d H:i:s",
            "date_end" => "required|date_format:Y-m-d H:i:s",
            "selling_price" => "required",
            "dad_percent" => "required",
            "artist_percent" => "required",
            "dad_price" => "required",
            "artist_price" => "required",
            "system_price" => "required",
            "opensea_price" => "required",
            "system_percent" => "required",
            "opensea_percent" => "required",
            "responsibility" => "required",
            "contact_info" => "required",
            "privacy_policy" => "required",
            "terms_contract" => "required",
            "accept_privacy_policy" => "required",
            "accept_terms_contract" => "required",
            "status" => "required",
        ];
    }
}
