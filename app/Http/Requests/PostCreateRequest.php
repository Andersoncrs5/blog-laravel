<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostCreatehRequest extends FormRequest
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
            'title' => ['required', 'max:500'],
            'content' => ['required', 'max:3000', 'min:50'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The title is required.',
            'title.max' => 'The title must not exceed 500 characters.',

            'content.required' => 'The content is required.',
            'content.min' => 'The content must be at least 50 characters long.',
            'content.max' => 'The content must not exceed 3000 characters.',
        ];
    }

}
