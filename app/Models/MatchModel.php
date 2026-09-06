<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MatchModel extends Model
{
    protected $table = 'matches';

    protected $fillable = [
        'user_one_id',
        'user_two_id',
        'status',
    ];

    public function userOne()
    {
        return $this->belongsTo(User::class, 'user_one_id');
    }

    public function userTwo()
    {
        return $this->belongsTo(User::class, 'user_two_id');
    }

    public function exchanges()
    {
        return $this->hasMany(Exchange::class, 'match_id');
    }

    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_one_id', $userId)->orWhere('user_two_id', $userId);
    }

    public function other(int $userId): User
    {
        return $this->user_one_id === $userId ? $this->userTwo : $this->userOne;
    }

    public function includesUser(int $userId): bool
    {
        return $this->user_one_id === $userId || $this->user_two_id === $userId;
    }

    public static function between(int $userAId, int $userBId): ?self
    {
        return static::where('user_one_id', min($userAId, $userBId))
            ->where('user_two_id', max($userAId, $userBId))
            ->first();
    }
}
