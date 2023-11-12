<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTweetRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'tweet_text' => 'required|string|max:280',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ];
    }
}