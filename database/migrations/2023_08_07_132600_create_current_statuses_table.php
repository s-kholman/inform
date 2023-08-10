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
        Schema::create('current_statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_id')->constrained();
            $table->string('hostname', 255);
            $table->ipAddress('ip');
            $table->foreignId('filial_id');
            $table->foreignId('status_id');
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('current_statuses');
    }
};
