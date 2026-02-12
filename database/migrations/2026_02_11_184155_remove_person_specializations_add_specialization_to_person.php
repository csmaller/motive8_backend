<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add specialization column to person table
        Schema::table('person', function (Blueprint $table) {
            $table->text('specialization')->nullable()->after('bio');
        });
        
        // Drop person_specializations table
        Schema::dropIfExists('person_specializations');
    }

    public function down(): void
    {
        // Recreate person_specializations table
        Schema::create('person_specializations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('person_id')->constrained('person')->onDelete('cascade');
            $table->string('specialization');
            $table->timestamps();
        });
        
        // Remove specialization column from person table
        Schema::table('person', function (Blueprint $table) {
            $table->dropColumn('specialization');
        });
    }
};
