<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        if (session('is_adm') == true && session('active') == true )
        {
            return true;
        }

        return false;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'max:200']
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The category name is required.',
            'name.max' => 'The category name must not exceed 200 characters.',
        ];
    }
}
