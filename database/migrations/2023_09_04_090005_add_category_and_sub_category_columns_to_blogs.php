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
        Schema::table('blogs', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->default(null)->constrained('categories', 'id')->nullOnDelete();
            $table->foreignId('sub_category_id')->nullable()->default(null)->constrained('sub_categories', 'id')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->removeColumn('category_id');
            $table->removeColumn('sub_category_id');
        });
    }
};
