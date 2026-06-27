<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingPayment extends Model
{
    protected $fillable = [
        'booking_id','payment_type','amount','payment_method',
        'transaction_id','received_by','notes','payment_date',
    ];

    protected $casts = ['payment_date' => 'date'];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }
}
