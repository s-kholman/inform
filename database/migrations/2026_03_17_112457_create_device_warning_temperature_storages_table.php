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
        Schema::create('device_warning_temperature_storages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('storage_name_id')->constrained()->onDelete('cascade');;
            $table->foreignId('role_id')->constrained()->onDelete('cascade');
            $table->float('temperature_max');
            $table->float('temperature_min')->default(0);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_warning_temperature_storages');
    }
};
