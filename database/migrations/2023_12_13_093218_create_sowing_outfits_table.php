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
        Schema::create('sowing_outfits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sowing_last_name_id')->constrained();
            $table->foreignId('filial_id')->constrained();
            $table->foreignId('sowing_type_id')->constrained();
            $table->foreignId('machine_id')->constrained();
            $table->foreignId('harvest_year_id')->constrained();
            $table->boolean('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sowing_outfits');
    }
};
