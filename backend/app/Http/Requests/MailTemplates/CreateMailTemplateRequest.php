<?php

namespace App\Http\Requests\MailTemplates;

use App\Http\Requests\FormRequest;

class CreateMailTemplateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "subject" => "required",
            "content" => "required",
            "type" => "required",
        ];
    }
}
