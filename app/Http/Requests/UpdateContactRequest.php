<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $contactId = $this->route('contact')->id ?? null;

        return [
            'name' => ['required', 'string', 'min:5'],
            'contact' => [
                'required',
                'digits:9',
                Rule::unique('contacts', 'contact')
                    ->ignore($contactId)
                    ->whereNull('deleted_at'),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('contacts', 'email')
                    ->ignore($contactId)
                    ->whereNull('deleted_at'),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The Name field is required.',
            'name.string' => 'The Name must be a string.',
            'name.min' => 'The Name must be at least 5 characters.',

            'contact.required' => 'The Contact field is required.',
            'contact.digits' => 'The Contact must be exactly 9 digits.',
            'contact.unique' => 'Another contact with this number already exists.',

            'email.required' => 'The Email field is required.',
            'email.email' => 'The Email must be a valid email address.',
            'email.unique' => 'Another contact with this Email already exists.',
        ];
    }
}
