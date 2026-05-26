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
    protected $guarded = [];

    protected $casts = [
        'date_issued' => 'date',
        'date_expire' => 'date',
        'date_inspection' => 'date',
        'improvements' => AsArrayObject::class,
        'financial_values' => AsArrayObject::class,
        'stocking_records' => 'array',
        'harvest_records' => AsArrayObject::class,
        'pond_types' => AsArrayObject::class,
        'with_pending_admin_case' => 'boolean',
        'with_pending_judicial_case' => 'boolean',
    ];

    public function lessee(): BelongsTo
    {
        return $this->belongsTo(Lessee::class);
    }
}
