<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('velocity_classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instructor_id')->constrained('person')->onDelete('cascade');
            $table->string('day');
            $table->string('time');
            $table->string('duration');
            $table->string('title');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('velocity_classes');
    }
};
