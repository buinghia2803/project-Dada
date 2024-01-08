<?php

namespace App\Http\Requests\Admin\Users;

use App\Http\Requests\FormRequest;

class CreateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "public_address_main" => "required|unique:users|max:126",
            "full_name" => "required|max:126",
            "email" => !empty($this->email) ? "email|max:255" : '',
            "positions" => "max:126",
            "description" => "max:500"
        ];
    }
    public function messages()
    {
        return [
           "public_address_main.unique" => "メタマスクIDが既に登録されました。",
           "public_address_main.max" => "126文字以内で入力してください。",
           "public_address_main.required" => "必須項目に入力してください。",
           "email.max" => "126文字以内で入力してください。",
           "email.required" => "必須項目に入力してください。",
           "positions.max" => "126文字以内で入力してください。",
           "description.max" => "126文字以内で入力してください。",
        ];
    }
}
