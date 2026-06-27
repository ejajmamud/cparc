<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'reference_number','booker_name','booker_phone','booker_email',
        'booker_address','booker_nid','package_id','event_type','event_type_other',
        'event_date','start_time','end_time','guests_count','special_requests',
        'status','admin_notes','confirmed_at','cancelled_at',
        'total_amount','advance_paid','payment_method','transaction_id',
    ];

    protected $casts = [
        'event_date'   => 'date',
        'confirmed_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(BookingPayment::class);
    }

    public function getTotalPaidAttribute(): int
    {
        return $this->payments()->sum('amount');
    }

    public function getBalanceDueAttribute(): int
    {
        return max(0, $this->total_amount - $this->advance_paid);
    }

    public static function generateReference(): string
    {
        $year = now()->year;
        $last = static::whereYear('created_at', $year)->max('id') ?? 0;
        return 'CPRC-' . $year . '-' . str_pad($last + 1, 4, '0', STR_PAD_LEFT);
    }

    public static function isDateAvailable(string $date, int $packageId, ?int $excludeId = null): bool
    {
        $query = static::where('event_date', $date)
            ->whereIn('status', ['pending', 'confirmed']);
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        return $query->count() < 2; // allow max 2 bookings per day (day + night slots)
    }

    public static function eventTypes(): array
    {
        return [
            'wedding'   => ['en' => 'Wedding', 'bn' => 'বিবাহ অনুষ্ঠান'],
            'reception' => ['en' => 'Reception / Walima', 'bn' => 'রিসেপশন / ওয়ালিমা'],
            'birthday'  => ['en' => 'Birthday / Anniversary', 'bn' => 'জন্মদিন / বার্ষিকী'],
            'corporate' => ['en' => 'Corporate Event', 'bn' => 'কর্পোরেট ইভেন্ট'],
            'cultural'  => ['en' => 'Cultural Programme', 'bn' => 'সাংস্কৃতিক অনুষ্ঠান'],
            'seminar'   => ['en' => 'Seminar / Conference', 'bn' => 'সেমিনার / কনফারেন্স'],
            'other'     => ['en' => 'Other', 'bn' => 'অন্যান্য'],
        ];
    }
}
