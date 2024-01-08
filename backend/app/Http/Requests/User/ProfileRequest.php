<?php

namespace App\Http\Requests\User;

use App\Http\Requests\FormRequest;

class ProfileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'max:255',
            'old_password' => 'min:6|max:255',
            'new_password' => 'min:6|max:255',
        ];
    }
}
