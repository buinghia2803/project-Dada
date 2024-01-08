<?php

namespace App\Http\Requests\Admin\Notifications;

use App\Http\Requests\FormRequest;

class UpdateNotificationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "title" => "required",
            "content" => "required",
            "date_public" => "required",
            "type" => "required",
            "date_public" => "required",
        ];
    }
}
