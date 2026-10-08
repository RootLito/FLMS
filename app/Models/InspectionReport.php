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

    /**
     * Relationship with Lessee
     */
    public function lessee(): BelongsTo
    {
        return $this->belongsTo(Lessee::class);
    }

    /**
     * Required by LaravelSignPad to specify where to position/render
     * the signature on documents or PDFs if needed.
     */
    public function getSignatureFileName(): string
    {
        return "inspection_report_{$this->id}_signature.png";
    }

    /**
     * Safely fallback site_photos to an empty array when null.
     */
    public function getSitePhotosAttribute($value): array
    {
        return is_string($value) ? json_decode($value, true) : ($value ?? []);
    }

    /**
     * Safely fallback att_photos to an empty array when null.
     */
    public function getAttPhotosAttribute($value): array
    {
        return is_string($value) ? json_decode($value, true) : ($value ?? []);
    }
}