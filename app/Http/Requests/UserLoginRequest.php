<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserLoginRequest extends FormRequest
{
    public function authorize(): bool
    {

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
            'email' => ['required', 'email', 'min:8', 'max:250'],
            'password' => ['required', 'min:8', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.min' => 'The email must be at least 8 characters.',
            'email.max' => 'The email must not exceed 250 characters.',

            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.max' => 'The password must not exceed 100 characters.',
        ];
    }
}
