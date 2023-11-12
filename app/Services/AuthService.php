<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function registerUser($data)
    {
        $data['username'] = $this->generateUniqueUsername($data['email']);
        $data['password'] = Hash::make($data['password']);
        return User::create($data);
    }

    public function generateUniqueUsername(string $email): string
    {
        $emailStr = explode('@', $email)[0];
        $username = $emailStr . rand(100, 999);
        $checkUsernameExists = User::where('username', $username)->exists();
        if ($checkUsernameExists) {
            $username = $this->generateUniqueUsername($email);
        }
        return $username;
    }

    public function respondWithToken($token): JsonResponse
    {
        $expiration = 24 * 60 * 60; // 24 hours in seconds

        return response()->json([
            'success' => true,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $expiration,
            'user' => auth()->user(),
        ]);
    }
}
