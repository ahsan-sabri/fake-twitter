<?php

namespace App\Http\Requests;

use App\Models\User;
use HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

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
