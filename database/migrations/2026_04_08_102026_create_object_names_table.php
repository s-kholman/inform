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
        Schema::create('object_names', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->foreignId('filial_id')->constrained()->onDelete('cascade');
            $table->foreignId('object_type_id')->constrained()->onDelete('cascade');
            $table->foreignId('pole_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('object_names');
    }
};
