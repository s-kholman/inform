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
        Schema::table('device_e_s_p_s', function (Blueprint $table) {
            $table->string('activate_code')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('device_e_s_p_s', function (Blueprint $table) {
            $table->dropColumn('activate_code');
        });
    }
};
