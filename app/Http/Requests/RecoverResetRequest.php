<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecoverResetRequest extends FormRequest
{
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
            'password' => ['required', 'min:8', 'max:100'],
            'confirm-password' => ['required', 'min:8', 'max:100', 'same:password'],
        ];
    }

    public function messages(): array
    {
        return [
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.max' => 'The password must not exceed 100 characters.',

            'confirm-password.required' => 'The confirm password field is required.',
            'confirm-password.min' => 'The confirm password must be at least 8 characters.',
            'confirm-password.max' => 'The confirm password must not exceed 100 characters.',
            'confirm-password.same' => 'The confirm password must match the password.',
        ];
    }

}