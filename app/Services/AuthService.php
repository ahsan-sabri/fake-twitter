<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function registerUser($data)
    {
        $data['password'] = Hash::make($data['password']);
        return User::create($data);
    }

    public function respondWithToken($token): JsonResponse
    {
        $expiration = 5 * 24 * 60; // 5 days in minutes

        return response()->json([
            'success' => true,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => now()->addMinutes($expiration)->timestamp,
            'user' => auth()->user(),
        ]);
    }
}
