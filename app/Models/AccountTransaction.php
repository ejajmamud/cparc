<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccountTransaction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'type', 'category', 'sub_category', 'amount', 'transaction_date',
        'description', 'reference_number', 'payment_method', 'bank_name',
        'cheque_number', 'voucher_number', 'approved_by', 'remarks',
        'attachment', 'created_by',
    ];

    protected $casts = [
        'transaction_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public static function incomeCategories(): array
    {
        return [
            'hall_rental'      => ['en' => 'Hall Rental',        'bn' => 'হল ভাড়া'],
            'membership_fee'   => ['en' => 'Membership Fee',     'bn' => 'সদস্যপদ ফি'],
            'restaurant'       => ['en' => 'Restaurant Income',  'bn' => 'রেস্তোরাঁ আয়'],
            'event_ticket'     => ['en' => 'Event Ticket',       'bn' => 'ইভেন্ট টিকেট'],
            'donation'         => ['en' => 'Donation',           'bn' => 'দান/অনুদান'],
            'investment_return'=> ['en' => 'Investment Return',  'bn' => 'বিনিয়োগ আয়'],
            'government_grant' => ['en' => 'Government Grant',   'bn' => 'সরকারি অনুদান'],
            'sports_fee'       => ['en' => 'Sports Fee',         'bn' => 'ক্রীড়া ফি'],
            'locker_fee'       => ['en' => 'Locker/Storage Fee', 'bn' => 'লকার ফি'],
            'misc_income'      => ['en' => 'Miscellaneous',      'bn' => 'বিবিধ আয়'],
        ];
    }

    public static function expenseCategories(): array
    {
        return [
            'salary'           => ['en' => 'Salary & Wages',     'bn' => 'বেতন ও মজুরি'],
            'utilities'        => ['en' => 'Utilities',          'bn' => 'বিদ্যুৎ/গ্যাস/পানি'],
            'maintenance'      => ['en' => 'Maintenance/Repair', 'bn' => 'রক্ষণাবেক্ষণ'],
            'cleaning'         => ['en' => 'Cleaning',           'bn' => 'পরিষ্কার-পরিচ্ছন্নতা'],
            'security'         => ['en' => 'Security',           'bn' => 'নিরাপত্তা'],
            'event_expense'    => ['en' => 'Event Expense',      'bn' => 'অনুষ্ঠান ব্যয়'],
            'stationery'       => ['en' => 'Stationery/Office',  'bn' => 'স্টেশনারি/অফিস'],
            'transport'        => ['en' => 'Transport',          'bn' => 'পরিবহন'],
            'food_beverage'    => ['en' => 'Food & Beverage',    'bn' => 'খাদ্য ও পানীয়'],
            'equipment'        => ['en' => 'Equipment/Furniture','bn' => 'যন্ত্রপাতি/আসবাব'],
            'insurance'        => ['en' => 'Insurance',          'bn' => 'বীমা'],
            'tax'              => ['en' => 'Tax & Govt. Fee',    'bn' => 'কর ও সরকারি ফি'],
            'misc_expense'     => ['en' => 'Miscellaneous',      'bn' => 'বিবিধ ব্যয়'],
        ];
    }

    public static function allCategoryOptions(): array
    {
        $opts = [];
        foreach (static::incomeCategories() as $k => $v) {
            $opts[$k] = $v['en'] . ' (Income)';
        }
        foreach (static::expenseCategories() as $k => $v) {
            $opts[$k] = $v['en'] . ' (Expense)';
        }
        return $opts;
    }

    public static function incomeCategoryOptions(): array
    {
        return array_map(fn($v) => $v['en'], static::incomeCategories());
    }

    public static function expenseCategoryOptions(): array
    {
        return array_map(fn($v) => $v['en'], static::expenseCategories());
    }

    public static function monthlySummary(int $year, int $month): array
    {
        $income  = static::where('type','income')->whereYear('transaction_date',$year)->whereMonth('transaction_date',$month)->sum('amount');
        $expense = static::where('type','expense')->whereYear('transaction_date',$year)->whereMonth('transaction_date',$month)->sum('amount');
        return [
            'income'  => (float) $income,
            'expense' => (float) $expense,
            'balance' => (float) $income - (float) $expense,
        ];
    }

    public static function yearlySummary(int $year): array
    {
        $rows = static::whereYear('transaction_date', $year)
            ->selectRaw('type, MONTH(transaction_date) as m, SUM(amount) as total')
            ->groupBy('type', 'm')
            ->get();

        $income = array_fill(1, 12, 0);
        $expense = array_fill(1, 12, 0);

        foreach ($rows as $row) {
            if ($row->type === 'income') {
                $income[(int)$row->m] = (float) $row->total;
            } else {
                $expense[(int)$row->m] = (float) $row->total;
            }
        }

        return ['income' => $income, 'expense' => $expense];
    }

    public static function generateVoucher(string $type): string
    {
        $prefix = $type === 'income' ? 'RCV' : 'PYT';
        $date   = now()->format('Ymd');
        $last   = static::withTrashed()->where('type', $type)->whereDate('created_at', now()->toDateString())->count();
        return $prefix . '-' . $date . '-' . str_pad($last + 1, 4, '0', STR_PAD_LEFT);
    }
}
