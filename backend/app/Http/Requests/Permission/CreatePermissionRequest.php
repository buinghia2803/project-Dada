<?php
namespace App\Http\Requests\Permission;

use App\Http\Requests\FormRequest;

class CreatePermissionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'guard_name' => 'required',
        ];
    }
}
