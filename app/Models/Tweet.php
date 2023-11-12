<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static create($data)
 * @method static whereIn(string $string, array $timelineTweeters)
 */
class Tweet extends Model
{
    protected $fillable = [
        'user_id',
        'tweet_text'
    ];

    public function tweeter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
