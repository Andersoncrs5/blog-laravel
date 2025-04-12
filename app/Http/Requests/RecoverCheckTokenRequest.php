<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecoverCheckTokenRequest extends FormRequest
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
            'token' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'The token field is required.',
        ];
    }
}
