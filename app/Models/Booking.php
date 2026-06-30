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
        'booker_address','booker_nid','verification_document','package_id','booking_shift','rental_type','booker_type',
        'event_type','event_type_other','event_date','event_end_date','event_days','start_time','end_time','guests_count',
        'special_requests','status','admin_notes','confirmed_at','cancelled_at',
        'total_amount','advance_paid','payment_method','transaction_id',
    ];

    protected $casts = [
        'event_date'     => 'date',
        'event_end_date' => 'date',
        'confirmed_at'   => 'datetime',
        'cancelled_at'   => 'datetime',
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

    /**
     * Calculate total BDT price dynamically based on:
     * - bookerType: general, staff, member
     * - shift: day, night
     * - rentalType: hall, hall_field
     */
    public static function calculatePrice(
        string $bookerType,
        string $shift,
        string $rentalType,
        int $days = 1
    ): int {
        $prices = [
            'general' => 18000,
            'staff'   => 5000,
            'member'  => 3000,
        ];

        $perDay = $prices[$bookerType] ?? 18000;

        if ($rentalType === 'hall_field') {
            $perDay += 10000;
        }

        if ($shift === 'night') {
            $perDay += ($bookerType === 'general') ? 2000 : 1500;
        }

        // Multi-day discount: 10% off per extra day (capped at 30%)
        $discount = min(($days - 1) * 0.10, 0.30);

        return (int) round($perDay * $days * (1 - $discount));
    }

    public static function isDateAvailable(string $date, string $shift, ?int $excludeId = null): bool
    {
        $query = static::where('booking_shift', $shift)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where(function ($q) use ($date) {
                // Conflicts if existing booking's date range overlaps with this date
                $q->where('event_date', '<=', $date)
                  ->where(function ($q2) use ($date) {
                      $q2->whereNull('event_end_date')
                         ->orWhere('event_end_date', '>=', $date);
                  });
            });
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        return $query->count() === 0;
    }

    public static function isRangeAvailable(string $startDate, string $endDate, string $shift, ?int $excludeId = null): bool
    {
        $query = static::where('booking_shift', $shift)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where(function ($q) use ($startDate, $endDate) {
                $q->where('event_date', '<=', $endDate)
                  ->where(function ($q2) use ($startDate) {
                      $q2->whereNull('event_end_date')
                         ->orWhere('event_end_date', '>=', $startDate);
                  });
            });
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        return $query->count() === 0;
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
