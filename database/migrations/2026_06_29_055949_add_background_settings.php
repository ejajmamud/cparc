<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $defaults = [
            ['key' => 'bg_type',            'value' => 'white'],
            ['key' => 'bg_pattern_image',   'value' => null],
            ['key' => 'bg_opacity',         'value' => '30'],
            ['key' => 'bg_overlay_color',   'value' => '#ffffff'],
            ['key' => 'bg_overlay_opacity', 'value' => '0'],
        ];

        foreach ($defaults as $row) {
            DB::table('settings')->updateOrInsert(
                ['key' => $row['key']],
                ['value' => $row['value'], 'created_at' => now(), 'updated_at' => now()]
            );
        }
    }

    public function down(): void
    {
        DB::table('settings')->whereIn('key', [
            'bg_type', 'bg_pattern_image', 'bg_opacity',
            'bg_overlay_color', 'bg_overlay_opacity',
        ])->delete();
    }
};
