<?php

namespace App\Http\Requests\Offer;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateOfferRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->hasRole('Contratista');
    }

    public function rules(): array
    {
        return [
            'title'         => 'sometimes|required|string',
            'description'   => 'nullable|string',
            'salary'        => 'sometimes|required|numeric|min:0',
            'city_id'       => 'sometimes|required|exists:cities,id',
            'user_id'       => 'sometimes|required|exists:users,id',
            'closing_date'  => 'nullable|date',
            'is_active'     => 'boolean',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}

