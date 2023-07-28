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
        Schema::create('sokar_f_i_o_s', function (Blueprint $table) {
            $table->id();
            $table->string('last', 100);
            $table->string('first', 100);
            $table->string('middle', 100)->nullable();
            $table->integer('gender');
            $table->json('size');
            $table->boolean('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sokar_f_i_o_s');
    }
};
