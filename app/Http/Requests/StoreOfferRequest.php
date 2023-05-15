<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreOfferRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->hasRole('Contratista');
    }

    public function rules(): array
    {
        return [
            'title'         => 'required|string',
            'description'   => 'nullable|string',
            'salary'        => 'required|numeric|min:0',
            'city_id'       => 'required|exists:cities,id',
            'user_id'       => 'required|exists:users,id',
            'closing_date'  => 'nullable|date_format:Y-m-d',
            'is_active'     => 'boolean',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
