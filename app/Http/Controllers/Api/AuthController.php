<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct(private readonly AuthService $authService)
    {
        //
    }

    public function register(RegistrationRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $req = $request->validated();
            $this->authService->registerUser($req);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Registration successful!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'issue' => $e->getMessage(),
                'message' => 'Registration failed!'
            ])->setStatusCode(ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $credentials = $request->validated();

            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email or password are incorrect!'
                ])->setStatusCode(ResponseAlias::HTTP_UNAUTHORIZED);
            }

            return $this->authService->respondWithToken($token);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'issue' => $e->getMessage(),
                'message' => "Couldn't create token!",
            ])->setStatusCode(ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getAuthUser(): JsonResponse
    {
        return response()->json(auth()->user());
    }

    public function refresh(): JsonResponse
    {
        try {
            $newToken = auth()->refresh();
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'issue' => $e->getMessage(),
                'message' => "Couldn't refresh token!",
            ])->setStatusCode(ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->authService->respondWithToken($newToken);
    }
}
