<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UnfollowRequest extends FormRequest
{
    public function rules(): array
    {
        $invalidIds = [auth()->id()];
        $followingIds = User::find(auth()->id())->following()->pluck('id')->all();

        return [
            'unfollow_to' => [
                'integer',
                'required',
                'exists:users,id',
                Rule::In($followingIds),
                Rule::notIn($invalidIds)
            ],
        ];
    }
}
