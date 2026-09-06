<?php

namespace App\Models;

use App\Enums\ExchangeStatus;
use App\Enums\ExchangeType;
use Illuminate\Database\Eloquent\Model;

class Exchange extends Model
{
    protected $fillable = [
        'match_id',
        'requester_id',
        'requested_item_id',
        'offered_item_id',
        'type',
        'status',
        'message',
    ];

    protected $casts = [
        'type' => ExchangeType::class,
        'status' => ExchangeStatus::class,
    ];

    public function match()
    {
        return $this->belongsTo(MatchModel::class, 'match_id');
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function requestedItem()
    {
        return $this->belongsTo(Item::class, 'requested_item_id');
    }

    public function offeredItem()
    {
        return $this->belongsTo(Item::class, 'offered_item_id');
    }
}
