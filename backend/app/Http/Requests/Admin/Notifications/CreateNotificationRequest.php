<?php

namespace App\Http\Requests\Admin\Notifications;

use App\Http\Requests\FormRequest;

class CreateNotificationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "title" => "required",
            "content" => "required",
            "type" => "required",
            "date_public" => "required",
        ];
    }
}
