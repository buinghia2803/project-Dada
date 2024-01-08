<?php

namespace App\Http\Requests\Admin\ContractPayments;

use App\Http\Requests\FormRequest;

class UpdateContractPaymentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "status" => "required",
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
            'status',
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
            'status.required'                  => "この項目は必須です。",
        ];
    }
}
