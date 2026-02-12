<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // First, add missing columns
        Schema::table('news', function (Blueprint $table) {
            if (!Schema::hasColumn('news', 'category')) {
                $table->string('category')->default('general');
            }
            if (!Schema::hasColumn('news', 'tags')) {
                $table->json('tags')->nullable();
            }
            if (!Schema::hasColumn('news', 'featured')) {
                $table->boolean('featured')->default(false);
            }
            if (!Schema::hasColumn('news', 'status')) {
                $table->string('status')->default('draft');
            }
            if (!Schema::hasColumn('news', 'read_time')) {
                $table->integer('read_time')->nullable();
            }
        });
        
        // Modify author_id to match users.id type exactly
        if (Schema::hasColumn('news', 'author_id')) {
            DB::statement('ALTER TABLE news MODIFY author_id INT NULL');
        } else {
            Schema::table('news', function (Blueprint $table) {
                $table->integer('author_id')->nullable();
            });
        }
        
        // Add foreign key only if it doesn't exist
        $foreignKeys = DB::select("
            SELECT CONSTRAINT_NAME 
            FROM information_schema.TABLE_CONSTRAINTS 
            WHERE TABLE_NAME = 'news' 
            AND CONSTRAINT_TYPE = 'FOREIGN KEY'
            AND CONSTRAINT_NAME = 'news_author_id_foreign'
        ");
        
        if (empty($foreignKeys)) {
            Schema::table('news', function (Blueprint $table) {
                $table->foreign('author_id')->references('id')->on('users')->onDelete('set null');
            });
        }
    }

    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            if (Schema::hasColumn('news', 'author_id')) {
                $table->dropForeign(['author_id']);
            }
            
            $columns = ['category', 'tags', 'featured', 'status', 'read_time'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('news', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
