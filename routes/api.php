<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FollowController;
use App\Http\Controllers\Api\TweetController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['as' => 'api.'], static function () {
    // auth
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register'])->name('register');
});

Route::group(['as' => 'api.', 'middleware' => ['auth:api']], static function () {
    // user
    Route::get('user', [AuthController::class, 'getAuthUser'])->name('user');
    Route::post('refresh', [AuthController::class, 'refresh'])->name('refresh');

    // follow
    Route::post('follow', [FollowController::class, 'follow'])->name('follow');
    Route::post('unfollow', [FollowController::class, 'unfollow'])->name('unfollow');

    // tweet
    Route::resource('tweets', TweetController::class);
    Route::get('tweet/timeline', [TweetController::class, 'timeline'])->name('timeline');
});
