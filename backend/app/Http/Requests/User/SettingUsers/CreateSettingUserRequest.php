<?php

namespace App\Http\Requests\User\SettingUsers;

use App\Http\Requests\FormRequest;

class CreateSettingUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "user_id" => "required",
            "contract_notify" => "required",
            "system_notify" => "required",
        ];
    }
}
