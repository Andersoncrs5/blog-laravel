<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostSearchRequest extends FormRequest
{
    public function authorize(): bool
    {
        if (session('active') == false)
        {
            return false;
        }

        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The title is required.',
            'title.max' => 'The title must not exceed 1000 characters.',
        ];
    }
}
