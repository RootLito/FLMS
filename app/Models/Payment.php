<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Payment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'invoice_id',
        'lessee_id',
        'date',
        'amount',
        'payment_method',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2',
    ];

    protected static function booted()
    {
        static::creating(function ($payment) {
            $nextId = DB::table('payments')->max('id') + 1;

            $payment->invoice_id = '#' . str_pad($nextId, 5, '0', STR_PAD_LEFT);
        });
    }





    /**
     * Get the lessee that owns the payment.
     */
    public function lessee(): BelongsTo
    {
        return $this->belongsTo(Lessee::class);
    }
}
