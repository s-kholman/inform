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
        Schema::create('sokar_spisanies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sokar_f_i_o_s_id')->constrained()->onDelete('cascade');
            $table->foreignId('sokar_sklad_id')->constrained()->onDelete('cascade');
            $table->integer('count');
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sokar_spisanies');
    }
};
