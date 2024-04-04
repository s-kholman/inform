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
        Schema::rename('polivs', 'waterings');

        Schema::table('waterings', function (Blueprint $table) {
            $dafault = \App\Models\HarvestYear::query()->where('name', '2023')->value('id');
            $table->foreignId('harvest_year_id')->default($dafault);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('waterings', 'polivs');

        Schema::table('polivs', function (Blueprint $table) {
            $table->dropColumn('harvest_year_id');
        });
    }
};
