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
        Schema::table('sowing_hoeing_potato', function (Blueprint $table) {
            $table->integer('hoeing_result_agronomist_point_1')->nullable()->default(null);
            $table->integer('hoeing_result_agronomist_point_2')->nullable()->default(null);
            $table->integer('hoeing_result_agronomist_point_3')->nullable()->default(null);
            $table->integer('hoeing_result_director_point_1')->nullable()->default(null);
            $table->integer('hoeing_result_director_point_2')->nullable()->default(null);
            $table->integer('hoeing_result_director_point_3')->nullable()->default(null);
            $table->integer('hoeing_result_deputy_director_point_1')->nullable()->default(null);
            $table->integer('hoeing_result_deputy_director_point_2')->nullable()->default(null);
            $table->integer('hoeing_result_deputy_director_point_3')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sowing_hoeing_potato', function (Blueprint $table) {
            $table->dropColumn('hoeing_result_agronomist_point_1');
            $table->dropColumn('hoeing_result_agronomist_point_2');
            $table->dropColumn('hoeing_result_agronomist_point_3');
            $table->dropColumn('hoeing_result_director_point_1');
            $table->dropColumn('hoeing_result_director_point_2');
            $table->dropColumn('hoeing_result_director_point_3');
            $table->dropColumn('hoeing_result_deputy_director_point_1');
            $table->dropColumn('hoeing_result_deputy_director_point_2');
            $table->dropColumn('hoeing_result_deputy_director_point_3');
        });
    }
};
