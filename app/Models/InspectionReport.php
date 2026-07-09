<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Creagia\LaravelSignPad\Concerns\RequiresSignature;
use Creagia\LaravelSignPad\Contracts\CanBeSigned;

class InspectionReport extends Model implements CanBeSigned
{
    use RequiresSignature;

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
        'date_inspection',
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
        'improvements',
        'financial_values',
        'stocking_records',
        'harvest_records',
        'pond_types',
        'with_pending_admin_case',
        'with_pending_judicial_case',
    ];

    protected $casts = [
        'from' => 'date',
        'to' => 'date',
        'date_issued' => 'date',
        'date_expire' => 'date',
        'date_inspection' => 'date',
        'no_hec_granted' => 'decimal:2',
        'no_hec_developed' => 'decimal:2',
        'no_hect_undeveloped' => 'decimal:2',
        'items' => 'array',
        'stocking' => 'array',
        'harvesting' => 'array',
        'marketing' => 'array',
        'site_photos' => 'array',
        'improvements' => AsArrayObject::class,
        'financial_values' => AsArrayObject::class,
        'stocking_records' => 'array',
        'harvest_records' => AsArrayObject::class,
        'pond_types' => AsArrayObject::class,
        'with_pending_admin_case' => 'boolean',
        'with_pending_judicial_case' => 'boolean',
        'signature_data' => 'string',
    ];

    public function lessee(): BelongsTo
    {
        return $this->belongsTo(Lessee::class);
    }
}