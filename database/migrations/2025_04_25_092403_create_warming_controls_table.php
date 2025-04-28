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
        Schema::create('warming_controls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warming_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->string('text', 255);
            $table->integer('level');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warming_controls');
    }
};
