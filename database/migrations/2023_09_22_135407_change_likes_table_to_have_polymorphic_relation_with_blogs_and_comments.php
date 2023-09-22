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
        Schema::table('likes', function (Blueprint $table) {
            $table->bigInteger('likable_id', false, true)->change();
            $table->string('likable_type')->default('App\Models\Blog');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('likes', function (Blueprint $table) {
            $table->foreignId('likable_id')->constrained('blogs', 'id')->cascadeOnDelete();
            $table->dropColumn('likable_type');
        });
    }
};
