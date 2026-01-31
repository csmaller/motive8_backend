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
        if (!Schema::hasTable('person_specializations')) {
            Schema::create('person_specializations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('person_id')->constrained('person')->onDelete('cascade');
            $table->string('specialization');
            $table->text('description')->nullable();
            $table->timestamps();
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('person_specializations');
    }
};
