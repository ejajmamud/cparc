<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->foreignId('package_id')->nullable()->change();
            
            $table->string('booking_shift', 20)->default('day')->after('package_id');
            $table->string('rental_type', 30)->default('hall')->after('booking_shift');
            $table->string('booker_type', 30)->default('general')->after('rental_type');
            
            $table->index(['event_date', 'booking_shift', 'status']);
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropIndex(['event_date', 'booking_shift', 'status']);
            $table->dropColumn(['booking_shift', 'rental_type', 'booker_type']);
            $table->foreignId('package_id')->nullable(false)->change();
        });
    }
};
