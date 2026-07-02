<?php

namespace App\Http\Controllers;

use App\Models\AccountTransaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class AccountPdfController extends Controller
{
    public function monthly(Request $request)
    {
        $month = (int) $request->get('month', now()->month);
        $year  = (int) $request->get('year', now()->year);

        $transactions = AccountTransaction::where('year', $year)
            ->where('month', $month)
            ->orderBy('deposit_date')
            ->orderBy('id')
            ->get();

        $totals = [
            'income'      => $transactions->sum('income_amount'),
            'expense'     => $transactions->sum('expense_amount'),
            'electricity' => $transactions->sum('electricity_bill'),
            'refund'      => $transactions->sum('refund_amount'),
        ];

        $monthNames = [
            1=>'জানুয়ারি',2=>'ফেব্রুয়ারি',3=>'মার্চ',4=>'এপ্রিল',
            5=>'মে',6=>'জুন',7=>'জুলাই',8=>'আগস্ট',
            9=>'সেপ্টেম্বর',10=>'অক্টোবর',11=>'নভেম্বর',12=>'ডিসেম্বর',
        ];

        $monthName = $monthNames[$month] . '-' . $year . 'ইং';

        $pdf = Pdf::loadView('pdf.accounts-monthly', compact('transactions', 'totals', 'monthName', 'month', 'year'))
            ->setPaper('a4', 'landscape')
            ->setOptions([
                'defaultFont'    => 'DejaVu Sans',
                'isRemoteEnabled'=> true,
                'dpi'            => 150,
            ]);

        return $pdf->stream("accounts-{$year}-{$month}.pdf");
    }
}
