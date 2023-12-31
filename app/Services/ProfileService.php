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

    public function searchUsers(string $queryString)
    {
        return User::select('id', 'name', 'email', 'username')
                ->where(function ($query) use($queryString) {
                $query->where('name', 'like', "%{$queryString}%")
                    ->orWhere('email', 'like', "%{$queryString}%")
                    ->orWhere('username', 'like', "%{$queryString}%");
                    })
                ->where('id', '!=', auth()->id())->paginate(20);
    }

    public function getUserAvatar($userId): string
    {
        $avatar = '/img/profile/avatar.jpg';
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
