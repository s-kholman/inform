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
        Schema::create('sprayings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pole_id')->constrained();
            $table->date('date');
            $table->foreignId('sevooborot_id')->constrained();
            $table->foreignId('szr_id')->constrained();
            $table->float('doza');
            $table->float('volume');
            $table->string('comments', 500)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sprayings');
    }
};
