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
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255)->unique();
            $table->string('category');
            $table->string('creator');
            $table->integer('year');
            $table->string('studio')->nullable();
            $table->string('country')->nullable();
            $table->string('genre')->nullable();
            $table->integer('total_volumes')->nullable();
            $table->integer('duration_minutes')->nullable();
            $table->integer('total_chapters')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
