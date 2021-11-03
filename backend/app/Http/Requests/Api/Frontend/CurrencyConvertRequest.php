<?php

namespace App\Http\Requests\Api\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class CurrencyConvertRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'currency' => 'required',
            'rate' => 'required|numeric',
        ];
    }
}
