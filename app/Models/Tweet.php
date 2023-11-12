<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

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

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    protected static function boot(): void
    {
        parent::boot();

        // Order by created_at DESC
        static::addGlobalScope('order', static function (Builder $builder) {
            $builder->orderBy('created_at', 'desc');
        });
    }
}
