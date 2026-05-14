<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lessee extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'full_name',
        'barangay',
        'municipality',
        'province',
        'fla_no',
        'date_issued',
        'date_expiration',
        'hec_granted',
        'hec_developed',
        'hec_undeveloped',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'date_issued' => 'date',
        'date_expiration' => 'date',
        'hec_granted' => 'decimal:2',
        'hec_developed' => 'decimal:2',
        'hec_undeveloped' => 'decimal:2',
    ];



    public function fishpondMap()
    {
        return $this->hasOne(FishpondMap::class);
    }
}
