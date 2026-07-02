<!DOCTYPE html>
<html lang="bn">
<head>
<meta charset="UTF-8">
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: 'DejaVu Sans', sans-serif; font-size: 10px; color: #000; background: #fff; }

  .page { padding: 15px 20px; }

  .header { text-align: center; margin-bottom: 12px; }
  .header img { height: 55px; }
  .header h1 { font-size: 15px; font-weight: bold; margin-top: 4px; text-decoration: underline; }

  table { width: 100%; border-collapse: collapse; margin-top: 8px; }
  th, td { border: 1px solid #000; padding: 4px 5px; text-align: center; vertical-align: middle; }
  th { background: #f0f0f0; font-weight: bold; font-size: 9px; }
  td { font-size: 9px; }
  td.left { text-align: left; }
  td.right { text-align: right; }
  td.amount { text-align: right; font-weight: bold; }

  .total-row td { font-weight: bold; background: #e8e8e8; }
  .serial { width: 28px; }
  .date-col { width: 70px; }
  .amount-col { width: 65px; }
  .cheque-col { width: 60px; }
  .elec-col { width: 55px; }
  .serial-col { width: 55px; }
  .refund-col { width: 50px; }
  .bank-col { width: auto; }
  .desc-col { width: 110px; }

  .footer { margin-top: 30px; display: flex; justify-content: space-between; }
  .footer-sig { text-align: center; width: 22%; }
  .footer-sig .sig-line { border-top: 1px solid #000; margin-top: 35px; padding-top: 4px; font-size: 9px; }

  .zero { color: #999; }
</style>
</head>
<body>
<div class="page">

  <div class="header">
    <img src="{{ public_path('images/club/logo.jpeg') }}" alt="Logo">
    <h1>{{ $monthName }} মাসের আয়-ব্যয়ের হিসাব</h1>
  </div>

  <table>
    <thead>
      <tr>
        <th class="serial" rowspan="2">ক্রঃ<br>নং</th>
        <th class="date-col" rowspan="2">জমা/উত্তোলনের<br>তারিখ</th>
        <th class="date-col" rowspan="2">অনুষ্ঠানের<br>তারিখ</th>
        <th class="amount-col" rowspan="2">আয়/<br>জমা</th>
        <th class="amount-col" rowspan="2">ব্যয়/<br>উত্তোলন</th>
        <th class="cheque-col" rowspan="2">চেক<br>নম্বর</th>
        <th class="elec-col" rowspan="2">বিদ্যুৎ<br>বিল</th>
        <th class="serial-col" rowspan="2">সিরিয়াল<br>নং</th>
        <th class="refund-col" rowspan="2">ফেরত</th>
        <th class="bank-col" rowspan="2">ব্যাংক জমার বিবরণ<br>(টাকা ও রশিদ নং)</th>
        <th class="desc-col" rowspan="2">বিবরণ</th>
      </tr>
    </thead>
    <tbody>
      @forelse($transactions as $i => $t)
      <tr>
        <td>{{ $i + 1 }}</td>
        <td>{{ $t->deposit_date ? $t->deposit_date->format('d-m-Y') : '—' }}</td>
        <td>{{ $t->event_date ? $t->event_date->format('d-m-Y') : '—' }}</td>
        <td class="amount">{{ $t->income_amount > 0 ? number_format($t->income_amount, 0) : '' }}</td>
        <td class="amount">{{ $t->expense_amount > 0 ? number_format($t->expense_amount, 0) : '' }}</td>
        <td>{{ $t->cheque_number ?? '--' }}</td>
        <td class="amount">{{ $t->electricity_bill > 0 ? number_format($t->electricity_bill, 0) : '' }}</td>
        <td>{{ $t->cheque_serial ?? '--' }}</td>
        <td class="amount">{{ $t->refund_amount > 0 ? number_format($t->refund_amount, 0) : '' }}</td>
        <td class="left">{{ $t->bank_deposit_details ?? '' }}</td>
        <td class="left">{{ $t->description ?? '' }}</td>
      </tr>
      @empty
      <tr>
        <td colspan="11" style="text-align:center; padding:20px; color:#666;">
          এই মাসে কোনো লেনদেন নেই।
        </td>
      </tr>
      @endforelse
    </tbody>
    <tfoot>
      <tr class="total-row">
        <td colspan="3" style="text-align:right;">সর্বমোট =</td>
        <td class="amount">{{ number_format($totals['income'], 0) }}</td>
        <td class="amount">{{ number_format($totals['expense'], 0) }}</td>
        <td></td>
        <td class="amount">{{ $totals['electricity'] > 0 ? number_format($totals['electricity'], 0) : '' }}</td>
        <td></td>
        <td class="amount">{{ $totals['refund'] > 0 ? number_format($totals['refund'], 0) : '' }}</td>
        <td colspan="2"></td>
      </tr>
    </tfoot>
  </table>

  <div class="footer">
    <div class="footer-sig">
      <div class="sig-line">দপ্তর সম্পাদক<br>বন্দর রিপাবলিক ক্লাব</div>
    </div>
    <div class="footer-sig">
      <div class="sig-line">কোষাধ্যক্ষ<br>বন্দর রিপাবলিক ক্লাব</div>
    </div>
    <div class="footer-sig">
      <div class="sig-line">সাধারণ সম্পাদক<br>বন্দর রিপাবলিক ক্লাব</div>
    </div>
    <div class="footer-sig">
      <div class="sig-line">সভাপতি<br>বন্দর রিপাবলিক ক্লাব</div>
    </div>
  </div>

</div>
</body>
</html>
