<?php

namespace App\Http\Requests\User;

use App\Http\Requests\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return  array
     */
    public function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            // 'roles.*' => 'integer|min:0',
        ];
    }
}
