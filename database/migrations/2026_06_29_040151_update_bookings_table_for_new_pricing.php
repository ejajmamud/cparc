<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Drop the required package_id FK — replaced by direct pricing model
            if (Schema::hasColumn('bookings', 'package_id')) {
                $table->dropForeign(['package_id']);
                $table->dropColumn('package_id');
            }

            // New pricing columns
            if (!Schema::hasColumn('bookings', 'booker_type')) {
                $table->enum('booker_type', ['general', 'staff', 'member'])
                    ->default('general')
                    ->after('booker_nid');
            }
            if (!Schema::hasColumn('bookings', 'booking_shift')) {
                $table->enum('booking_shift', ['day', 'night'])
                    ->default('day')
                    ->after('booker_type');
            }
            if (!Schema::hasColumn('bookings', 'rental_type')) {
                $table->enum('rental_type', ['hall', 'hall_field'])
                    ->default('hall')
                    ->after('booking_shift');
            }
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['booker_type', 'booking_shift', 'rental_type']);
            $table->foreignId('package_id')->nullable()->constrained()->cascadeOnDelete();
        });
    }
};
