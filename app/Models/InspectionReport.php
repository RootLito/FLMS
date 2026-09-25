<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Creagia\LaravelSignPad\Concerns\RequiresSignature;
use Creagia\LaravelSignPad\Contracts\CanBeSigned;

class InspectionReport extends Model implements CanBeSigned
{
    use RequiresSignature;

    protected $fillable = [
        'lessee_id',
        'fla_no',
        'barangay',
        'municipality',
        'province',
        'date_issued',
        'date_expire',
        'date_inspection',
        'no_hec_granted',
        'no_hec_developed',
        'no_hect_undeveloped',
        'improvement',
        'att_photos',
        'operation',
        'verification',
        'case_status',
        'remarks',
        'officer',
        'designation',
        'site_photos',
    ];

    protected $casts = [
        'date_issued' => 'date',
        'date_expire' => 'date',
        'date_inspection' => 'date',
        'no_hec_granted' => 'decimal:2',
        'no_hec_developed' => 'decimal:2',
        'no_hect_undeveloped' => 'decimal:2',
        'improvement' => 'array',
        'att_photos' => 'array',
        'operation' => 'array',
        'verification' => 'array',
        'case_status' => 'array',
        'site_photos' => 'array',
    ];

    public function lessee(): BelongsTo
    {
        return $this->belongsTo(Lessee::class);
    }
}