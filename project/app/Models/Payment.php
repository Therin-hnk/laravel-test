<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'booking_id',
        'amount',
        'status',
    ];

    protected $casts = [
        'status' => 'string', // Cast ENUM to string
        'amount' => 'decimal:2',
    ];

    // Relations
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}