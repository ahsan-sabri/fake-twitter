<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchUserRequest;
use App\Http\Requests\UpdateAvatarRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use App\Services\ProfileService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UserController extends Controller
{
    public function __construct(private readonly ProfileService $profileService)
    {
        //
    }

    public function getUserProfile($id): JsonResponse
    {
        try {
            $profile = $this->profileService->getUserProfileById($id);

            return response()->json([
                'success' => true,
                'data' => $profile
            ])->setStatusCode(ResponseAlias::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'issue' => $e->getMessage(),
                'message' => 'Something went wrong!'
            ])->setStatusCode(ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateProfile(UpdateProfileRequest $request): JsonResponse
    {
        try {
            $req = $request->validated();
            $req['id'] = auth()->id();
            $this->profileService->updateProfile($req);

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully!'
            ])->setStatusCode(ResponseAlias::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'issue' => $e->getMessage(),
                'message' => 'Something went wrong!'
            ])->setStatusCode(ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateAvatar(UpdateAvatarRequest $request): JsonResponse
    {
        try {
            $image['file'] = $request->file('image');
            $image['path'] = '/img/profile/';
            $image['id'] = auth()->id();
            $image['model'] = User::class;
            $this->profileService->updateAvatar($image);

            return response()->json([
                'success' => true,
                'message' => 'Avatar updated successfully!'
            ])->setStatusCode(ResponseAlias::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'issue' => $e->getMessage(),
                'message' => 'Something went wrong!'
            ])->setStatusCode(ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function searchUsers(SearchUserRequest $request): JsonResponse
    {
        try {
            $req = $request->validated();
            $users = $this->profileService->searchUsers($req['query_string']);

            return response()->json([
                'success' => true,
                'data' => $users,
                'message' => 'Users fetched successfully!'
            ])->setStatusCode(ResponseAlias::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'issue' => $e->getMessage(),
                'message' => 'Something went wrong!'
            ])->setStatusCode(ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
