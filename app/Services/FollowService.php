<?php

namespace App\Services;

use App\Models\Follow;
use Carbon\Carbon;

class FollowService
{

    public function follow(int $follow_to)
    {
        $data['follow_to'] = $follow_to;
        $data['follow_from'] = auth()->id();
        $data['followed_at'] = Carbon::now();
        return Follow::create($data);
    }

    public function unfollow(int $unfollow_to): void
    {
        Follow::where('follow_from', auth()->id())->where('follow_to', $unfollow_to)->delete();
    }
}
