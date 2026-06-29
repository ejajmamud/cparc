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
        $settings = [
            ['key' => 'whatsapp_number', 'value' => '+8801700000000'],
            ['key' => 'phone_number', 'value' => '+880312500000'],
            ['key' => 'contact_email', 'value' => 'info@cpa.gov.bd'],
            ['key' => 'smtp_host', 'value' => 'smtp.mailtrap.io'],
            ['key' => 'smtp_port', 'value' => '2525'],
            ['key' => 'smtp_username', 'value' => ''],
            ['key' => 'smtp_password', 'value' => ''],
            ['key' => 'smtp_encryption', 'value' => 'tls'],
            ['key' => 'smtp_from_address', 'value' => 'no-reply@cparc.ejaj.website'],
            ['key' => 'smtp_from_name', 'value' => 'Chittagong Port Republic Club'],
        ];

        foreach ($settings as $setting) {
            \Illuminate\Support\Facades\DB::table('settings')->updateOrInsert(
                ['key' => $setting['key']],
                ['value' => $setting['value'], 'created_at' => now(), 'updated_at' => now()]
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
