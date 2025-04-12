<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentCreateOnCommentRequest extends FormRequest
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
            'content' => ['required', 'max:500'],
            'post_id' => ['required']
        ];
    }

    function messages(): array
    {
        return [
            'content.required' => 'The content is required.',
            'content.max' => 'The content must not exceed 500 characters.',
            'post_id' => 'The id of post is required',
        ];
    }
}
