<?php

namespace App\Models;

use App\Services\ProfileService;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * @method static create(array $array)
 * @method static where(string $string, string $username)
 * @method static find(int|string|null $auth_id)
 * @method static whereIn(string $string, mixed[] $toArray)
 * @method static select(string $string)
 * @property mixed $id
 */
class User extends Authenticatable implements JWTSubject
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'date_of_birth',
        'gender',
        'email_verified_at',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = [
        'avatar',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }

    // relations
    public function followers()
    {
        $follows = $this->hasMany(Follow::class, 'follow_to');
        return User::whereIn('id', $follows->pluck('follow_from')->all())->get();
    }

    public function following()
    {
        $follows = $this->hasMany(Follow::class, 'follow_from');
        return User::whereIn('id', $follows->pluck('follow_to')->all())->get();
    }

    public function tweets(): HasMany
    {
        return $this->hasMany(Tweet::class);
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function getAvatarAttribute(): string
    {
        $profileService = new ProfileService();
        return $profileService->getUserAvatar($this->id);
    }
}
