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
        Schema::create('posevs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fio_id')->constrained()->onDelete('cascade');
            $table->foreignId('kultura_id')->constrained()->onDelete('cascade');
            $table->foreignId('filial_id')->constrained()->onDelete('cascade');
            $table->foreignId('sutki_id')->default('1')->constrained()->onDelete('cascade');
            $table->foreignId('vidposeva_id')->constrained()->onDelete('cascade');
            $table->foreignId('agregat_id')->constrained()->onDelete('cascade');
            $table->foreignId('svyaz_id')->constrained()->onDelete('cascade');
            $table->date('posevDate');
            $table->float('posevGa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posevs');
    }
};
