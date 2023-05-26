<?php

namespace App\Http\Requests\Offer;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreOfferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'         => 'required|string',
            'description'   => 'nullable|string',
            'salary'        => 'required|numeric|min:0',
            'city'          => 'required|string',
            'department'    => 'required|string',
            'closing_date'  => 'nullable|date_format:Y-m-d',
            'is_active'     => 'boolean',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
