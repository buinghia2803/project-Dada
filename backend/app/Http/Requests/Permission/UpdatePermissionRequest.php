<?php

namespace App\Http\Requests\Permission;

use App\Http\Requests\FormRequest;

class UpdatePermissionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required',
            'name' => 'required',
            'guard_name' => 'required',
            'created_at' => 'required',
            'updated_at' => 'required',
        ];
    }
}
