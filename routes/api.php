<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FollowController;
use App\Http\Controllers\Api\TweetController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['as' => 'api.'], static function () {
    // auth
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register'])->name('register');
});

Route::group(['as' => 'api.', 'middleware' => ['auth:api']], static function () {
    // user
    Route::get('user', [AuthController::class, 'getAuthUser'])->name('user');
    Route::get('profile/{id}', [UserController::class, 'getUserProfile'])->name('profile');
    Route::post('user/search', [UserController::class, 'searchUsers'])->name('user.search');
    Route::post('refresh', [AuthController::class, 'refresh'])->name('refresh');
    Route::post('profile/update', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::post('avatar/update', [UserController::class, 'updateAvatar'])->name('avatar.update');

    // follow
    Route::post('follow', [FollowController::class, 'follow'])->name('follow');
    Route::post('unfollow', [FollowController::class, 'unfollow'])->name('unfollow');

    // tweet
    Route::resource('tweets', TweetController::class);
    Route::post('tweet/update', [TweetController::class, 'updateTweet'])->name('tweet.update');
    Route::get('tweet/timeline', [TweetController::class, 'timeline'])->name('timeline');
});
