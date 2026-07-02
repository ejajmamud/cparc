<?php

namespace Database\Seeders;

use App\Models\AccountTransaction;
use Illuminate\Database\Seeder;

class JuneAccountsSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            // Row 1
            ['deposit_date'=>'2026-06-04','event_date'=>'2026-07-03','income_amount'=>18000,'electricity_bill'=>2000,'cheque_serial'=>'09382-6','bank_deposit_details'=>'18000/-, 00958606','description'=>null],
            // Row 2
            ['deposit_date'=>'2026-06-04','event_date'=>'2026-06-05','income_amount'=>5000,'electricity_bill'=>1500,'cheque_serial'=>'09358-6','bank_deposit_details'=>'5000/-, 00958607','description'=>null],
            // Row 3
            ['deposit_date'=>'2026-06-07','event_date'=>'2026-07-08','income_amount'=>3000,'electricity_bill'=>0,'cheque_serial'=>null,'bank_deposit_details'=>'3000/-, 00958608','description'=>null],
            // Row 4
            ['deposit_date'=>'2026-06-08','event_date'=>'2026-07-12','income_amount'=>18000,'electricity_bill'=>2000,'cheque_serial'=>'09469-6','bank_deposit_details'=>'18000/-, 00958609','description'=>null],
            // Row 5
            ['deposit_date'=>'2026-06-11','event_date'=>'2026-07-11','income_amount'=>18000,'electricity_bill'=>2000,'cheque_serial'=>'09488-6','bank_deposit_details'=>'18000/-, 00958640','description'=>null],
            // Row 6
            ['deposit_date'=>'2026-06-11','event_date'=>'2026-07-10','income_amount'=>5000,'electricity_bill'=>2000,'cheque_serial'=>'09487-6','bank_deposit_details'=>'5000/-, 00926251','description'=>null],
            // Row 7
            ['deposit_date'=>'2026-06-14','event_date'=>'2026-07-29','income_amount'=>5000,'electricity_bill'=>1500,'cheque_serial'=>'09522-6','bank_deposit_details'=>'5000/-, 00926252','description'=>null],
            // Row 8 — bulk payment (মে মাসের ১৬টি অনুষ্ঠান এর বিল ও গোডাউন ভাড়া)
            ['deposit_date'=>'2026-06-14','event_date'=>null,'income_amount'=>91705,'electricity_bill'=>0,'cheque_serial'=>null,'bank_deposit_details'=>'91705/-, 00926253','description'=>'মা ডেকো: মে মাসের ১৬টি অনুষ্ঠান এর বিল ও গোডাউন ভাড়া'],
            // Row 9
            ['deposit_date'=>'2026-06-14','event_date'=>'2026-07-17','income_amount'=>13000,'electricity_bill'=>2000,'cheque_serial'=>'09523-6','bank_deposit_details'=>'13000/-, 00926254','description'=>null],
            // Row 10
            ['deposit_date'=>'2026-06-18','event_date'=>'2026-07-13','income_amount'=>18000,'electricity_bill'=>2000,'cheque_serial'=>'09622-6','bank_deposit_details'=>'18000/-, 00926255','description'=>null],
            // Row 11
            ['deposit_date'=>'2026-06-15','event_date'=>'2026-07-09','income_amount'=>18000,'electricity_bill'=>2000,'cheque_serial'=>'00002-7','bank_deposit_details'=>'18000/-, 00926256','description'=>null],
            // Row 12
            ['deposit_date'=>'2026-06-25','event_date'=>'2026-08-02','income_amount'=>18000,'electricity_bill'=>2000,'cheque_serial'=>'00001-7','bank_deposit_details'=>'18000/-, 00926257','description'=>null],
            // Row 13
            ['deposit_date'=>'2026-06-29','event_date'=>'2026-07-03','income_amount'=>3000,'electricity_bill'=>0,'cheque_serial'=>null,'bank_deposit_details'=>'3000/-, 00926258','description'=>null],
        ];

        foreach ($rows as $i => $row) {
            AccountTransaction::create([
                'voucher_number'     => AccountTransaction::generateVoucher(),
                'deposit_date'       => $row['deposit_date'],
                'event_date'         => $row['event_date'],
                'type'               => 'income',
                'category'           => isset($row['description']) && $row['description'] ? 'misc' : 'hall_rental',
                'income_amount'      => $row['income_amount'],
                'expense_amount'     => 0,
                'electricity_bill'   => $row['electricity_bill'],
                'refund_amount'      => 0,
                'cheque_number'      => null,
                'cheque_serial'      => $row['cheque_serial'],
                'payment_method'     => 'bank_transfer',
                'bank_name'          => null,
                'bank_deposit_details' => $row['bank_deposit_details'],
                'description'        => $row['description'],
                'approved_by'        => null,
                'month'              => (int) date('m', strtotime($row['deposit_date'])),
                'year'               => (int) date('Y', strtotime($row['deposit_date'])),
            ]);
        }

        $this->command->info('✅ June 2026 accounts seeded: 13 rows, total income ৳2,33,705');
    }
}
