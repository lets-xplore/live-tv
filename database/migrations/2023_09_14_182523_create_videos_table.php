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
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('uri')->nullable();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->string('link')->nullable();
            $table->string('player_embed_url')->nullable();
            $table->string('direct_url')->nullable();
            $table->integer('duration')->nullable();
            $table->string('pictures')->nullable(); // JSON column to store pictures data
            $table->string('thumb_image')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
