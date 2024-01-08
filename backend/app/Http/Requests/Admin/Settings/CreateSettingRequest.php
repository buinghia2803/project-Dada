<?php

namespace App\Http\Requests\Admin\Settings;

use App\Http\Requests\FormRequest;

class CreateSettingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "currency_eth" => "required",
            "opensea_percent" => "required",
            "system_percent" => "required",
        ];
    }
}
