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
        Schema::create('sowing_hoeing_potato', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('type_field_work_id')->constrained();
            $table->foreignId('sowing_last_name_id')->constrained();
            $table->foreignId('pole_id')->constrained();
            $table->foreignId('filial_id')->constrained();
            $table->float('volume');
            $table->foreignId('shift_id');
            $table->foreignId('harvest_year_id')->constrained();
            $table->integer('hoeing_result_agronomist')->nullable()->default(null);
            $table->integer('hoeing_result_director')->nullable()->default(null);
            $table->integer('hoeing_result_deputy_director')->nullable()->default(null);
            $table->string('comment', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sowing_hoeing_potato');
    }
};
