<?php

namespace App\Http\Requests\MailTemplates;

use App\Http\Requests\FormRequest;

class UpdateMailTemplateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "id" => "required",
            "subject" => "required",
            "content" => "required",
            "type" => "required",
        ];
    }
}
