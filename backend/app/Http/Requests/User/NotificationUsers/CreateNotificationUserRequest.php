<?php

namespace App\Http\Requests\User\NotificationUsers;

use App\Http\Requests\FormRequest;

class CreateNotificationUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "notification_id" => "required",
            "admin_id" => "required",
            "user_from" => "required",
            "user_to" => "required",
            "status" => "required",
        ];
    }
}
