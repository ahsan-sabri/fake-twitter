<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @method static create(array $array)
 */
class Image extends Model
{
    protected $fillable = [
        'title',
        'url',
        'image_type',
        'imageable_id',
        'imageable_type'
    ];

    public function imageable(): MorphTo
    {
        return $this->morphTo();
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
