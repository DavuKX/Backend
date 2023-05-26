<?php

namespace App\Http\Requests\Offer;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateOfferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'         => 'sometimes|required|string',
            'description'   => 'nullable|string',
            'salary'        => 'sometimes|required|numeric|min:0',
            'city'          => 'sometimes|string',
            'closing_date'  => 'nullable|date',
            'is_active'     => 'boolean',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}

