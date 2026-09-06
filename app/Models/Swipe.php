<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Swipe extends Model
{
    protected $fillable = [
        'swiper_user_id',
        'target_user_id',
        'liked',
    ];

    public function swiper()
    {
        return $this->belongsTo(User::class, 'swiper_user_id');
    }

    public function target()
    {
        return $this->belongsTo(User::class, 'target_user_id');
    }
}
