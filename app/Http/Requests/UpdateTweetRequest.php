<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTweetRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'tweet_text' => 'string|max:280',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ];
    }

    public function messages(): array
    {
        return [
            'image.max' => 'The image may not be greater than 25 MegaBytes.',
            'image.mimes' => 'The image must be of type jpeg,png,jpg,gif or svg.'
        ];
    }
}
