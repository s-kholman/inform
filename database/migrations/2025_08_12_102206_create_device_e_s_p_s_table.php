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
        Schema::create('device_e_s_p_s', function (Blueprint $table) {
            $table->id();
            $table->macAddress('mac')->unique();
            $table->text('description')->nullable();
            $table->foreignId('storage_name_id')->nullable();
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_e_s_p_s');
    }
};
