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
        Schema::create('factory_materials', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('filial_id');
            $table->string('fio', 255)->nullable();
            $table->foreignId('nomenklature_id');
            $table->string('photo_path', 255)->nullable();
            $table->foreignId('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factory_materials');
    }
};
