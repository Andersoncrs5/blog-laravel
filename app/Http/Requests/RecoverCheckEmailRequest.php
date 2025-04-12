<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecoverCheckEmailRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {

        if (session('active') == true)
        {
            return false;
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['email', 'required', 'max:250', 'min:8'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.min' => 'The email must be at least 8 characters long.',
            'email.max' => 'The email must not exceed 250 characters.',
        ];
    }

}
