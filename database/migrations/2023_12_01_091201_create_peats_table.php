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
        Schema::create('peats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peat_extraction_id')->constrained();
            $table->foreignId('pole_id')->constrained();
            $table->foreignId('filial_id')->constrained();
            $table->foreignId('harvest_year_id')->constrained();
            $table->date('date');
            $table->integer('volume');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peats');
    }
};
