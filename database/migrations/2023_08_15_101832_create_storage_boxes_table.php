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
        Schema::create('storage_boxes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('storage_name_id')->constrained();
            $table->string('field', 500)->nullable();
            $table->foreignId('kultura_id')->constrained();
            $table->foreignId('nomenklature_id')->constrained();
            $table->foreignId('reproduktion_id')->nullable()->constrained();
            $table->integer('type')->nullable()->default(0);
            $table->integer('volume');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('storage_boxes');
    }
};
