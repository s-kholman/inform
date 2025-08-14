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
            $table->float('temperaturePointOne')->nullable();
            $table->float('temperaturePointTwo')->nullable();
            $table->float('temperaturePointThree')->nullable();
            $table->float('temperatureHumidity')->nullable();
            $table->float('humidity')->nullable();
            $table->foreignId('harvest_year_id');
            $table->foreignId('device_e_s_p_id');
            $table->integer('ADC')->nullable();
            $table->string('RSSI')->nullable();
            $table->string('version')->nullable();
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
