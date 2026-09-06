<?php

namespace App\Models;

use App\Enums\ItemCondition;
use App\Enums\ItemStatus;
use App\Enums\ItemType;
use App\Enums\OfferType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'item_condition',
        'size',
        'type',
        'offer_type',
        'status',
    ];

    protected $casts = [
        'item_condition' => ItemCondition::class,
        'type' => ItemType::class,
        'offer_type' => OfferType::class,
        'status' => ItemStatus::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(ItemImage::class);
    }
}
