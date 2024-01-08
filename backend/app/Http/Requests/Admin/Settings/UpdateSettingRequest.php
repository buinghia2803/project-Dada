<?php

namespace App\Http\Requests\Admin\Settings;

use App\Http\Requests\FormRequest;

class UpdateSettingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "opensea_percent" => "required|numeric|min:0|max:100",
            "system_percent" => "required|numeric|min:0|max:100",
        ];
    }

    /**
     * Set request parameters.
     *
     * @return array
     */
    protected function fields()
    {
        return [
            'opensea_percent',
            'system_percent',
        ];
    }

    /**
     * Get the message that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'system_percent.required'                  => "必須項目に入力してください。",
            'system_percent.numeric'                  => "0〜100の数字を入力してください。",
            'system_percent.min'                  => "0〜100の数字を入力してください。",
            'system_percent.max'                  => "0〜100の数字を入力してください。",
            'opensea_percent.required'                  => "必須項目に入力してください。",
            'opensea_percent.numeric'                  => "0〜100の数字を入力してください。",
            'opensea_percent.min'                  => "0〜100の数字を入力してください。",
            'opensea_percent.max'                  => "0〜100の数字を入力してください。",
        ];
    }
}
