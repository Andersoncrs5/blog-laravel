<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotificationCreateRequest extends FormRequest
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
            'reason' => ['required', 'max:250'],
            'message' => ['required', 'min:50', 'max:1000']
        ];
    }

    public function messages(): array
    {
        return [
            'reason.required' => 'The reason is required.',
            'reason.max' => 'The reason must not exceed 250 characters.',
            
            'message.required' => 'The message is required.',
            'message.min' => 'The message must be at least 50 characters long.',
            'message.max' => 'The message must not exceed 1000 characters.',
        ];
    }

}
