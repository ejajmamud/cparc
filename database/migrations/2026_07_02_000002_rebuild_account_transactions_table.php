<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('account_transactions');

        Schema::create('account_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('voucher_number')->nullable()->unique();
            $table->date('deposit_date');              // জমা/উত্তোলনের তারিখ
            $table->date('event_date')->nullable();    // অনুষ্ঠানের তারিখ
            $table->enum('type', ['income', 'expense'])->default('income');
            $table->string('category')->default('hall_rental');
            $table->decimal('income_amount', 12, 2)->default(0);   // আয়/জমা
            $table->decimal('expense_amount', 12, 2)->default(0);  // ব্যয়/উত্তোলন
            $table->decimal('electricity_bill', 10, 2)->default(0);// বিদ্যুৎ বিল
            $table->decimal('refund_amount', 10, 2)->default(0);   // ফেরত
            $table->string('cheque_number')->nullable();            // চেক নম্বর
            $table->string('cheque_serial')->nullable();            // সিরিয়াল নং
            $table->enum('payment_method', ['cash','cheque','bank_transfer','mobile_banking','other'])->default('cash');
            $table->string('bank_name')->nullable();
            $table->string('bank_deposit_details')->nullable();    // ব্যাংক জমার বিবরণ
            $table->text('description')->nullable();               // বিবরণ
            $table->string('approved_by')->nullable();
            $table->string('attachment')->nullable();
            $table->tinyInteger('month')->nullable();
            $table->smallInteger('year')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['year', 'month']);
            $table->index('deposit_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('account_transactions');
    }
};
