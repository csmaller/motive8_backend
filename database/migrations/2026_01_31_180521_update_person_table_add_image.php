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
        Schema::table('person', function (Blueprint $table) {
            if (!Schema::hasColumn('person', 'image')) {
                $table->string('image')->nullable()->after('certification');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('person', function (Blueprint $table) {
            if (Schema::hasColumn('person', 'image')) {
                $table->dropColumn('image');
            }
        });
    }
};
