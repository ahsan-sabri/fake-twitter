<?php

namespace App\Services;

use App\Models\User;

class ProfileService
{
    public function getUserProfileById($id)
    {
        $user = User::find($id)->makeHidden(['password', 'remember_token', 'created_at', 'updated_at']);
        $user->setAttribute('tweets', $user->tweets);
        $user->setAttribute('followers', $user->followers());
        $user->setAttribute('following', $user->following());
        return $user;
    }

    public function getUserAvatar($userId): string
    {
        $avatar = '/img/avatar.jpg';
        $user = User::find($userId);
        if ($user->images()->count() > 0) {
            $avatar = $user->images->first()->url;
        }
        return config('constant.app_url') . $avatar;
    }

    public function updateProfile($data)
    {
        $user = User::find($data['id']);
        return $user->update($data);
    }

    public function updateAvatar($image): void
    {
        $globalService = new GlobalService();
        $globalService->processUploadedImage($image);
    }
}
