<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FollowRequest extends FormRequest
{
    public function rules(): array
    {
        $invalidIds = [auth()->id()];
        $followingIds = User::find(auth()->id())->following()->pluck('id')->all();
        $invalidIds = array_merge($invalidIds, $followingIds);

        return [
            'follow_to' => [
                'integer',
                'required',
                'exists:users,id',
                Rule::notIn($invalidIds)
            ],
        ];
    }
}
