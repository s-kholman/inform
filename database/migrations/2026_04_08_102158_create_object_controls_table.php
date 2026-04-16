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
        Schema::create('object_controls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('object_name_id')->constrained()->onDelete('cascade');
            $table->foreignId('filial_id')->constrained()->onDelete('cascade');
            $table->foreignId('object_control_point_id')->constrained()->onDelete('cascade');
            $table->foreignId('object_control_importance_id')->constrained()->onDelete('cascade');
            $table->foreignId('pole_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('messages')->nullable();
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('object_controls');
    }
};
