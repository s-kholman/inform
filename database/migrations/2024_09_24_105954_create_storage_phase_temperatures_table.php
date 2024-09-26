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
        Schema::create('storage_phase_temperatures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('storage_phase_id')->constrained();
            $table->float('temperature_min');
            $table->float('temperature_max');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('storage_phase_temperatures');
    }
};
