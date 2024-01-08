<?php

namespace App\Http\Requests\User\Users;

use App\Http\Requests\FormRequest;

class CreateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "public_address_main" => "required",
            "full_name" => "required",
        ];
    }
}
