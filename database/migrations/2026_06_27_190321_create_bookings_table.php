<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('reference_number', 20)->unique();
            // Booker details
            $table->string('booker_name');
            $table->string('booker_phone', 20);
            $table->string('booker_email')->nullable();
            $table->text('booker_address')->nullable();
            $table->string('booker_nid', 30)->nullable();
            // Event details
            $table->foreignId('package_id')->constrained()->cascadeOnDelete();
            $table->string('event_type'); // wedding, reception, birthday, corporate, cultural, other
            $table->string('event_type_other')->nullable();
            $table->date('event_date');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->unsignedSmallInteger('guests_count')->default(0);
            $table->text('special_requests')->nullable();
            // Status workflow
            $table->enum('status', ['pending','confirmed','cancelled','completed'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            // Payment tracking
            $table->unsignedBigInteger('total_amount')->default(0);
            $table->unsignedBigInteger('advance_paid')->default(0);
            $table->string('payment_method')->nullable();
            $table->string('transaction_id')->nullable();
            $table->timestamps();

            $table->index(['event_date', 'status']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
