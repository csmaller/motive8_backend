<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('velocity_classes', function (Blueprint $table) {
            // Drop old columns
            $table->dropForeign(['instructor_id']);
            $table->dropColumn(['instructor_id', 'day', 'time']);
            
            // Add new columns
            $table->string('name')->after('id');
            $table->string('schedule')->after('description');
            $table->integer('max_participants')->nullable()->after('duration');
            $table->integer('current_enrollment')->default(0)->after('max_participants');
            $table->string('instructor')->after('current_enrollment');
            $table->string('level')->after('instructor');
            $table->decimal('cost', 10, 2)->nullable()->after('level');
            $table->string('location')->nullable()->after('cost');
            $table->json('equipment')->nullable()->after('location');
            $table->json('prerequisites')->nullable()->after('equipment');
        });
    }

    public function down(): void
    {
        Schema::table('velocity_classes', function (Blueprint $table) {
            // Remove new columns
            $table->dropColumn([
                'name',
                'schedule',
                'max_participants',
                'current_enrollment',
                'instructor',
                'level',
                'cost',
                'location',
                'equipment',
                'prerequisites'
            ]);
            
            // Restore old columns
            $table->foreignId('instructor_id')->constrained('person')->onDelete('cascade');
            $table->string('day');
            $table->string('time');
        });
    }
};
