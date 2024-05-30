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
        Schema::table('sowing_last_names', function (Blueprint $table){
           $table->foreignId('filial_id')->nullable()->constrained();
           $table->boolean('dismissed')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sowing_last_names', function (Blueprint $table){
            $table->dropColumn(['filial_id', 'dismissed']);
        });

    }
};
