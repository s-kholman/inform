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
        Schema::create('sevooborots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kultura_id')->constrained();
            $table->foreignId('nomenklature_id')->nullable()->constrained();
            $table->foreignId('reproduktion_id')->nullable()->constrained();
            $table->foreignId('pole_id')->constrained();
            $table->float('square');
            $table->year('year');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sevooborots');
    }
};
