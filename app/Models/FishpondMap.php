<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FishpondMap extends Model
{
    protected $fillable = ['lessee_id', 'coordinates', 'color'];

    protected $casts = [
        'coordinates' => 'array', 
    ];

    public function lessee(): BelongsTo
    {
        return $this->belongsTo(Lessee::class);
    }
}
