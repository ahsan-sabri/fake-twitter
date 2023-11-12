<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'string',
            'email' => 'email|unique:users,email,' . auth()->id(),
            'gender' => 'in:male,female',
            'date_of_birth' => 'date|date_format:Y-m-d|before_or_equal:' . now()->subYears(18)->format('Y-m-d'),
        ];
    }
}
