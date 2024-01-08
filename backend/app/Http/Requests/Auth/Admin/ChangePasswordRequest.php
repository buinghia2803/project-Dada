<?php

namespace App\Http\Requests\Auth\Admin;

use App\Http\Requests\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'old_password' => 'required',
            'password' => 'required|string|confirmed'
        ];
    }
}
