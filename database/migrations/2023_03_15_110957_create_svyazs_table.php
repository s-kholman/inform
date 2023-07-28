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
        Schema::create('svyazs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fio_id')->constrained()->onDelete('cascade');
            $table->foreignId('filial_id')->constrained()->onDelete('cascade');
            $table->foreignId('vidposeva_id')->constrained()->onDelete('cascade');
            $table->foreignId('agregat_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->boolean('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('svyazs');
    }
};
