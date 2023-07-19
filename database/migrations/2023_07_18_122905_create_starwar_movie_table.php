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
        Schema::create('starwar_movie', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('overview');
            $table->string('poster_path');
            $table->string('backdrop_path');
            $table->jsonb('parts');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('starwar_movie');
    }
};
