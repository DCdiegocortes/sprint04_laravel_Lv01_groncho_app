<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UniverseImage extends Model
{
    protected $fillable = [
        'universe_id',
        'path',
        'position',
    ];

    public function universe()
    {
        return $this->belongsTo(Universe::class);
    }
}
