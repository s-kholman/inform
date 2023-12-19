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
        Schema::create('sowings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sowing_last_name_id')->constrained();
            $table->foreignId('cultivation_id')->constrained();
            $table->foreignId('filial_id')->constrained();
            $table->foreignId('shift_id')->constrained();
            $table->foreignId('sowing_type_id')->constrained();
            $table->foreignId('machine_id')->nullable()->constrained();
            $table->foreignId('harvest_year_id')->constrained();
            $table->date('date');
            $table->float('volume');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sowings');
    }
};
