<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_bn');
            $table->string('slug')->unique();
            $table->integer('duration_hours');
            $table->string('duration_label');
            $table->string('duration_label_bn');
            $table->decimal('price', 10, 2);
            $table->string('price_note')->default('Starting from');
            $table->text('description')->nullable();
            $table->text('description_bn')->nullable();
            $table->json('features')->nullable();
            $table->json('features_bn')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
