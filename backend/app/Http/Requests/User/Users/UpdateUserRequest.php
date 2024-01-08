<?php

namespace App\Http\Requests\User\Users;

use App\Http\Requests\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "public_address_main" => "",
            "full_name" => "",
        ];
    }
}
