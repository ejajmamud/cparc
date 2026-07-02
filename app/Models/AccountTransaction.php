<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccountTransaction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'voucher_number', 'deposit_date', 'event_date', 'type', 'category',
        'income_amount', 'expense_amount', 'electricity_bill', 'refund_amount',
        'cheque_number', 'cheque_serial', 'payment_method', 'bank_name',
        'bank_deposit_details', 'description', 'approved_by', 'attachment',
        'month', 'year', 'created_by',
    ];

    protected $casts = [
        'deposit_date'     => 'date',
        'event_date'       => 'date',
        'income_amount'    => 'decimal:2',
        'expense_amount'   => 'decimal:2',
        'electricity_bill' => 'decimal:2',
        'refund_amount'    => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::saving(function (self $t) {
            $t->month = $t->deposit_date?->month;
            $t->year  = $t->deposit_date?->year;
            if (empty($t->type)) {
                $t->type = $t->income_amount > 0 ? 'income' : 'expense';
            }
        });
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public static function categories(): array
    {
        return [
            'hall_rental'    => 'Hall Rental / হল ভাড়া',
            'membership_fee' => 'Membership Fee / সদস্যপদ ফি',
            'restaurant'     => 'Restaurant / রেস্তোরাঁ',
            'event_ticket'   => 'Event Ticket / ইভেন্ট',
            'donation'       => 'Donation / দান',
            'salary'         => 'Salary / বেতন',
            'utilities'      => 'Utilities / বিদ্যুৎ/গ্যাস',
            'maintenance'    => 'Maintenance / রক্ষণাবেক্ষণ',
            'misc'           => 'Miscellaneous / বিবিধ',
        ];
    }

    public static function generateVoucher(): string
    {
        $date = now()->format('Ymd');
        $last = static::withTrashed()->whereDate('created_at', now()->toDateString())->count();
        return 'VCH-' . $date . '-' . str_pad($last + 1, 4, '0', STR_PAD_LEFT);
    }

    public static function monthlySummary(int $year, int $month): array
    {
        $rows = static::where('year', $year)->where('month', $month)->get();
        return [
            'income'      => $rows->sum('income_amount'),
            'expense'     => $rows->sum('expense_amount'),
            'electricity' => $rows->sum('electricity_bill'),
            'refund'      => $rows->sum('refund_amount'),
            'net'         => $rows->sum('income_amount') - $rows->sum('expense_amount'),
        ];
    }

    public static function yearlySummary(int $year): array
    {
        $income  = array_fill(1, 12, 0);
        $expense = array_fill(1, 12, 0);
        $rows = static::where('year', $year)
            ->selectRaw('month, SUM(income_amount) as ti, SUM(expense_amount) as te')
            ->groupBy('month')->get();
        foreach ($rows as $r) {
            $income[(int)$r->month]  = (float) $r->ti;
            $expense[(int)$r->month] = (float) $r->te;
        }
        return compact('income', 'expense');
    }
}
