<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('account_transactions', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['income', 'expense']);
            $table->string('category');
            $table->string('sub_category')->nullable();
            $table->decimal('amount', 12, 2);
            $table->date('transaction_date');
            $table->tinyInteger('month')->storedAs('MONTH(transaction_date)');
            $table->smallInteger('year')->storedAs('YEAR(transaction_date)');
            $table->string('description')->nullable();
            $table->string('reference_number')->nullable();
            $table->enum('payment_method', ['cash','cheque','bank_transfer','mobile_banking','other'])->default('cash');
            $table->string('bank_name')->nullable();
            $table->string('cheque_number')->nullable();
            $table->string('voucher_number')->nullable()->unique();
            $table->string('approved_by')->nullable();
            $table->text('remarks')->nullable();
            $table->string('attachment')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['type', 'year', 'month']);
            $table->index('transaction_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('account_transactions');
    }
};
