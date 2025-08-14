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
        Schema::create('device_e_s_p_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_e_s_p_id')->unique();
            $table->boolean('update_status')->default(false);
            $table->string('update_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_e_s_p_settings');
    }
};
