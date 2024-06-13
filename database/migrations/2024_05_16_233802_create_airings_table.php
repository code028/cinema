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
        Schema::create('airings', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('cinema_id');
            $table->foreign('cinema_id')->references('id')->on('cinemas')->onDelete('cascade');
            $table->unsignedBigInteger('showing_id');
            $table->foreign('showing_id')->references('id')->on('showings')->onDelete('cascade');
            $table->unsignedBigInteger('room_id');
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');

            $table->time('startTime');
            $table->time('endTime');
            $table->date('day');

            $table->unique(['showing_id', 'room_id', 'day', 'startTime', 'endTime']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('airings');
    }
};
