<?php

namespace App\Http\Requests;

use App\Models\User;
use HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

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

    /**
     * @throws HttpResponseException
     */
//    protected function failedValidation(Validator|\Illuminate\Contracts\Validation\Validator $validator): void
//    {
//        throw new HttpResponseException(response()->json([
//            'success' => false,
//            'errors' => $validator->errors()->first()
//        ], ResponseAlias::HTTP_NOT_ACCEPTABLE));
//    }
}
