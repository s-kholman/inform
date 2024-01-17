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
        Schema::table('nomenklatures', function(Blueprint $table) {
            $table->dropForeign('nomenklatures_kultura_id_foreign');
            $table->renameColumn('kultura_id', 'cultivation_id');
            $table->foreign('cultivation_id')->references('id')->on('cultivations')->onDelete('cascade');

        });
        Schema::table('reproduktions', function(Blueprint $table) {
            $table->dropForeign('reproduktions_kultura_id_foreign');
            $table->renameColumn('kultura_id', 'cultivation_id');
            $table->foreign('cultivation_id')->references('id')->on('cultivations')->onDelete('cascade');
        });
        Schema::table('sevooborots', function(Blueprint $table) {
            $table->dropForeign('sevooborots_kultura_id_foreign');
            $table->renameColumn('kultura_id', 'cultivation_id');
            $table->foreign('cultivation_id')->references('id')->on('cultivations')->onDelete('cascade');
        });
        Schema::table('storage_boxes', function(Blueprint $table) {
            $table->dropForeign('storage_boxes_kultura_id_foreign');
            $table->renameColumn('kultura_id', 'cultivation_id');
            $table->foreign('cultivation_id')->references('id')->on('cultivations')->onDelete('cascade');
        });



    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
