<?php

namespace App\Http\Requests\Auth\Admin;

use App\Http\Requests\FormRequest;

class PasswordResetRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'token' => 'string|min:10',
            'password' => 'min:8|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:8',
        ];
    }
}
