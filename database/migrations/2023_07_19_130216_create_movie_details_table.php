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
        Schema::create('movie_details', function (Blueprint $table) {
            $table->id();
            $table->string('adult');
            $table->string('backdrop_path');
            $table->json('belongs_to_collection');
            $table->string('budget');
            $table->json('genres');
            $table->string('homepage');
            $table->integer('movie_id');
            $table->string('imdb_id');
            $table->string('original_language');
            $table->string('original_title');
            $table->text('overview');
            $table->string('popularity');
            $table->string('poster_path');
            $table->json('production_companies');
            $table->json('production_countries');
            $table->date('release_date');
            $table->integer('revenue');
            $table->integer('runtime');
            $table->json('spoken_languages');
            $table->string('status');
            $table->string('tagline');
            $table->string('title');
            $table->string('video');
            $table->string('vote_average');
            $table->integer('vote_count');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movie_details');
    }
};
