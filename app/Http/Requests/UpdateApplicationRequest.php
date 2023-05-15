<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateApplicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->id === $this->input('user_id') || Auth::user()->hasRole('Admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'user_id'   => 'sometimes|required|exists:users,id',
            'offer_id'  => 'sometimes|required|exists:offers,id',
            'status'    => 'sometimes|required|in:pending,accepted,rejected',
            'message'   => 'nullable|max:255',
        ];
    }
}
