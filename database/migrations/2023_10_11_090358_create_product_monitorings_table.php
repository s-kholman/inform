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
        Schema::create('product_monitorings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('storage_name_id');
            $table->date('date');
            $table->float('burtTemperature')->nullable()->default(null);
            $table->float('burtAboveTemperature')->nullable()->default(null);
            $table->float('tuberTemperatureMorning')->nullable()->default(null);
            $table->float('tuberTemperatureEvening')->nullable()->default(null);
            $table->integer('humidity')->nullable()->default(null);
            $table->foreignId('storage_phase_id')->constrained();
            $table->string('comment', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_monitorings');
    }
};
