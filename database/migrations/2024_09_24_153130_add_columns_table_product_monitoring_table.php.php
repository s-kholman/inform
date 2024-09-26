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
        Schema::table('product_monitorings', function (Blueprint $table) {
            $table->float('temperature_keeping')->nullable();
            $table->float('humidity_keeping')->nullable();
            $table->string('control_manager', 255)->nullable();
            $table->string('control_director', 255)->nullable();
            $table->foreignId('storage_phase_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_monitorings', function (Blueprint $table){
            $table->dropColumn('temperature_keeping');
            $table->dropColumn('humidity_keeping');
            $table->dropColumn('control_manager');
            $table->dropColumn('control_director');
        });
    }
};
