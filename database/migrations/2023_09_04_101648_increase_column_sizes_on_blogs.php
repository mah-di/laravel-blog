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
            $table->string('title', 2000)->change();
            $table->text('body')->change();
            $table->string('cover_image', 2000)->default(env('DEFAULT_COVER_IMAGE'))->change();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->string('title', 255)->change();
            $table->string('body', 255)->change();
            $table->string('cover_image', 255)->default(env('DEFAULT_COVER_IMAGE'))->change();
        });
    }
};
