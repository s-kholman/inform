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
        Schema::create('prikopkis', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('filial_id')->constrained();
            $table->foreignId('sevooborot_id')->constrained();
            $table->foreignId('prikopki_square_id')->constrained();
            $table->float('fraction_1')->nullable();
            $table->float('fraction_2')->nullable();
            $table->float('fraction_3')->nullable();
            $table->float('fraction_4')->nullable();
            $table->float('fraction_5')->nullable();
            $table->float('fraction_6')->nullable();
            $table->string('comment', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prikopkis');
    }
};
