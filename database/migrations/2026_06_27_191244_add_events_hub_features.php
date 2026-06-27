<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Enhance events table (inspired by events-hub Event model)
        Schema::table('events', function (Blueprint $table) {
            $table->time('start_time')->nullable()->after('time');
            $table->time('end_time')->nullable()->after('start_time');
            $table->date('end_date')->nullable()->after('event_date');
            $table->string('age_limit')->nullable()->after('venue_bn'); // e.g. "18+", "All ages"
            $table->unsignedSmallInteger('expected_guests')->default(0)->after('age_limit');
            $table->string('organizer')->nullable()->after('expected_guests'); // host/organizer name
            $table->string('organizer_bn')->nullable()->after('organizer');
            $table->softDeletes();
        });

        // 2. Soft deletes on other key tables
        Schema::table('bookings', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('notices', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('news_articles', function (Blueprint $table) {
            $table->softDeletes();
        });

        // 3. Newsletter subscriptions (from events-hub newsletters table)
        Schema::create('newsletter_subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->enum('status', ['active', 'unsubscribed'])->default('active');
            $table->string('locale', 5)->default('bn');
            $table->timestamps();
            $table->softDeletes();
        });

        // 4. Booking payment confirmations (inspired by events-hub TicketVerification)
        Schema::create('booking_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
            $table->enum('payment_type', ['advance', 'full', 'balance', 'refund'])->default('advance');
            $table->unsignedBigInteger('amount'); // BDT
            $table->string('payment_method'); // cash, bkash, nagad, bank, cheque
            $table->string('transaction_id')->nullable();
            $table->string('received_by')->nullable(); // admin name who recorded it
            $table->text('notes')->nullable();
            $table->date('payment_date');
            $table->timestamps();
        });

        // 5. Event tags (proper pivot — fixing events-hub's broken tag system)
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('name_bn')->nullable();
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('event_tag', function (Blueprint $table) {
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained()->cascadeOnDelete();
            $table->primary(['event_id', 'tag_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_tag');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('booking_payments');
        Schema::dropIfExists('newsletter_subscribers');

        Schema::table('news_articles', fn($t) => $t->dropSoftDeletes());
        Schema::table('notices',       fn($t) => $t->dropSoftDeletes());
        Schema::table('bookings',      fn($t) => $t->dropSoftDeletes());
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['start_time','end_time','end_date','age_limit','expected_guests','organizer','organizer_bn']);
            $table->dropSoftDeletes();
        });
    }
};
