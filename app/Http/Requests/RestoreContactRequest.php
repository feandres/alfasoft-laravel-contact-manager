<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use App\Models\Contact;

class RestoreContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [];
    }

    public function validateResolved()
    {
        parent::validateResolved();

        $contactId = $this->route('contact');
        $contact = Contact::withTrashed()->findOrFail($contactId);

        $emailExists = Contact::whereNull('deleted_at')
            ->where('email', $contact->email)
            ->exists();

        $contactExists = Contact::whereNull('deleted_at')
            ->where('contact', $contact->contact)
            ->exists();

        if ($emailExists || $contactExists) {
            $message = 'Cannot restore contact: ';
            if ($emailExists) $message .= 'Email already exists. ';
            if ($contactExists) $message .= 'Contact number already exists.';

            throw ValidationException::withMessages([
                'restore' => [$message],
            ]);
        }
    }
}
