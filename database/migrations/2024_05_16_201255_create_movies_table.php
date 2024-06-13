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
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('directors');
            $table->string('writers');
            $table->string('actors');
            $table->string('name');
            $table->string('duration');
            $table->string('image');
            $table->date('released');
            $table->float('rating');
            $table->text('description');
            $table->string('imdb');
            $table->longText('trailer');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
