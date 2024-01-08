<?php

namespace App\Http\Requests\User\Tokens;

use App\Http\Requests\FormRequest;

class CreateTokenRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "token_contract_offer" => "required",
        ];
    }
}
