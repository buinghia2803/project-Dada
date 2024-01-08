<?php

namespace App\Http\Requests\User\ContractNftUser;

use App\Http\Requests\FormRequest;

class CreateContractNftUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "contract_offer_id" => "required",
            "address_contract" => "required",
            "name" => "required",
            "image_url" => "required",
            "description" => "required",
            "token_url" => "required",
        ];
    }
}
