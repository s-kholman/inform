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
        Schema::create('polivs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('filial_id')->constrained()->onDelete('cascade');
            $table->foreignId('pole_id')->constrained()->onDelete('cascade');
            $table->string('gidrant', 3);
            $table->string('sector', 1);
            $table->date('date');
            $table->integer('poliv');
            $table->integer('speed')->nullable();
            $table->integer('KAC')->nullable();
            $table->string('comment', 500)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('polivs');
    }
};
