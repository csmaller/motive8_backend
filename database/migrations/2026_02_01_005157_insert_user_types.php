<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('user_type')->insert([
            ['type' => 'admin', 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'coach', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('user_type')->whereIn('type', ['admin', 'coach'])->delete();
    }
};
