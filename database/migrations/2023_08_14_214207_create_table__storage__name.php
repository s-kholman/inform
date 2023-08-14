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
        Schema::create('storage_names', function (Blueprint $table) {
            $table->id();
            $table->string('name',255);
            $table->foreignId('filial_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('storage_names', function (Blueprint $table) {
            Schema::dropIfExists('storage_names');
        });
    }
};
