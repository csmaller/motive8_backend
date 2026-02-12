<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('date');
            $table->string('time');
            $table->string('location');
            $table->text('description');
            $table->string('type');
            $table->boolean('registration_required')->default(false);
            $table->integer('max_participants')->nullable();
            $table->integer('current_participants')->default(0);
            $table->date('registration_deadline')->nullable();
            $table->decimal('cost', 8, 2)->nullable();
            $table->string('image_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
