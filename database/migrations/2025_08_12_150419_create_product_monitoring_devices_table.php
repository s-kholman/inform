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
        Schema::create('product_monitoring_devices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('storage_name_id');
            $table->float('temperature_point_one')->nullable()->default(null);
            $table->float('temperature_point_two')->nullable()->default(null);
            $table->float('temperature_point_three')->nullable()->default(null);
            $table->float('temperature_point_four')->nullable()->default(null);
            $table->float('temperature_point_five')->nullable()->default(null);
            $table->float('temperature_point_six')->nullable()->default(null);
            $table->float('temperature_humidity')->nullable()->default(null);
            $table->float('humidity')->nullable()->default(null);
            $table->foreignId('harvest_year_id');
            $table->foreignId('device_e_s_p_id');
            $table->integer('adc')->nullable();
            $table->string('rssi')->nullable();
            $table->foreignId('device_e_s_p_update_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_monitoring_devices');
    }
};
