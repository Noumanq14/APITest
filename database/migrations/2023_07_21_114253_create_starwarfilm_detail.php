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
        Schema::create('starwarfilm_detail', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('episode_id');
            $table->longText('opening_crawl');
            $table->string('director');
            $table->string('producer');
            $table->date('release_date');
            $table->json('characters');
            $table->json('planets');
            $table->json('starships');
            $table->json('vehicles');
            $table->json('species');
            $table->string('created');
            $table->string('edited');
            $table->string('url');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('starwarfilm_detail');
    }
};
