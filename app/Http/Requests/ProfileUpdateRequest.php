<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'subscribed_to_product_alerts' => ['sometimes', 'boolean'],
            'preferred_product_categories' => ['nullable', 'array'],
            'preferred_product_categories.*' => ['string', Rule::in(['Fruits', 'Vegetables', 'Grains'])],
            'preferred_language' => ['nullable', 'string', Rule::in(['en', 'hi'])],
        ];
    }
}
