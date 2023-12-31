<?php

namespace App\Services;

use App\Models\Tweet;
use App\Models\User;

class TweetService
{
    public function getUserTweets($userId) {
        return User::find($userId)->tweets;
    }

    public function getUserTimeline($userId)
    {
        $user = User::find($userId);
        $timelineTweeters = [$userId];
        $followingIds = $user->following()->pluck('id')->all();
        $timelineTweeters = array_merge($timelineTweeters, $followingIds);

        return Tweet::whereIn('user_id', $timelineTweeters)
                    ->with(['tweeter:id,name,username'])
                    ->paginate(20);
    }

    public function storeTweet($data) {
        return Tweet::create($data);
    }

    public function getTweetDetails($tweet) {
        $image = null;
        $tweet->load('tweeter:id,name,username');
        if ($tweet->images()->count() > 0) {
            $image = config('constant.app_url') . $tweet->images()->first()->url;
        }
        $tweet->setAttribute('image', $image);

        return $tweet;
    }
}
