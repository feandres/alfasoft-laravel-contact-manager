<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:5',
            'contact' => 'required|digits:9|unique:contacts,contact',
            'email' => 'required|email|unique:contacts,email',
        ];
    }

    public function messages(): array
    {
        return [
            // 'name.required' => 'The name field is required.',
            // 'name.string' => 'The name must be a string.',
            // 'name.min' => 'The name must be at least 5 characters.',

            // 'contact.required' => 'The contact field is required.',
            // 'contact.digits' => 'The contact must be exactly 9 digits.',
            // 'contact.unique' => 'The contact has already been taken.',

            // 'email.required' => 'The email field is required.',
            // 'email.email' => 'The email must be a valid email address.',
            // 'email.unique' => 'The email has already been taken.',
        ];
    }
}
