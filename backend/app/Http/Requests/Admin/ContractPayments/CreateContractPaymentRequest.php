<?php

namespace App\Http\Requests\Admin\ContractPayments;

use App\Http\Requests\FormRequest;

class CreateContractPaymentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "contract_offer_id" => "required",
            "contract_nft_id" => "required",
            "dad_price" => "required",
            "artist_price" => "required",
        ];
    }
}
