<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $data)
 * @method static where(string $string, int|string|null $id)
 */
class Follow extends Model
{
    protected $fillable = [
        'follow_to',
        'follow_from',
        'followed_at',
    ];
}
