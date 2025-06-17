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
        Schema::table('szrs', function (Blueprint $table) {
            $table->integer('interval_day_start')->nullable()->default(null);
            $table->integer('interval_day_end')->nullable()->default(null);
            $table->float('dosage')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
