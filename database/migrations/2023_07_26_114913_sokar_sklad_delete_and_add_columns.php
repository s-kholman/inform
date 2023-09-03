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

        Schema::table('sokar_sklads', function (Blueprint $table) {
            $table->dropColumn('height_id');
            $table->integer('size_height');
        });

        Schema::dropIfExists('heights');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sokar_sklads', function (Blueprint $table) {
            //
        });
    }
};
