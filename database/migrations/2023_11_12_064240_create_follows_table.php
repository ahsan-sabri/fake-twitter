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
        Schema::create('follows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('follow_from');
            $table->foreignId('follow_to');
            $table->datetime('followed_at');
            $table->timestamps();

            $table->foreign('follow_from', 'follow_from_fk')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('follow_to', 'follow_to_fk')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('follows');
    }
};
