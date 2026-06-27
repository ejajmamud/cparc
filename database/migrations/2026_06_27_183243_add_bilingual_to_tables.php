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
        Schema::table('notices', function (Blueprint $table) {
            $table->string('title_bn')->nullable()->after('title');
            $table->longText('content_bn')->nullable()->after('content');
        });
        Schema::table('news_articles', function (Blueprint $table) {
            $table->string('title_bn')->nullable()->after('title');
            $table->longText('content_bn')->nullable()->after('content');
        });
        Schema::table('events', function (Blueprint $table) {
            $table->string('title_bn')->nullable()->after('title');
            $table->text('description_bn')->nullable()->after('description');
            $table->string('venue_bn')->nullable()->after('venue');
        });
        Schema::table('members', function (Blueprint $table) {
            $table->string('name_bn')->nullable()->after('name');
            $table->string('designation_bn')->nullable()->after('designation');
        });
    }

    public function down(): void
    {
        Schema::table('notices', fn($t) => $t->dropColumn(['title_bn', 'content_bn']));
        Schema::table('news_articles', fn($t) => $t->dropColumn(['title_bn', 'content_bn']));
        Schema::table('events', fn($t) => $t->dropColumn(['title_bn', 'description_bn', 'venue_bn']));
        Schema::table('members', fn($t) => $t->dropColumn(['name_bn', 'designation_bn']));
    }
};
