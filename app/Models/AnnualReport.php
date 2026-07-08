<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnnualReport extends Model
{
    protected $fillable = [
        'lessee_id',
        'from',
        'to',
        'fla_no',
        'barangay',
        'municipality',
        'province',
        'date_issued',
        'date_expire',
        'no_hec_granted',
        'no_hec_developed',
        'no_hect_undeveloped',
        'items',
        'stocking',
        'harvesting',
        'marketing',
        'remarks',
        'site_photos',     
        'signature_data',  
    ];

    protected $casts = [
        'from' => 'date',
        'to' => 'date',
        'date_issued' => 'date',
        'date_expire' => 'date',
        'no_hec_granted' => 'decimal:2',
        'no_hec_developed' => 'decimal:2',
        'no_hect_undeveloped' => 'decimal:2',
        'items' => 'array',
        'stocking' => 'array',
        'harvesting' => 'array',
        'marketing' => 'array',
        'site_photos' => 'array',
        'signature_data' => 'string',
    ];

    public function lessee(): BelongsTo
    {
        return $this->belongsTo(Lessee::class);
    }
}