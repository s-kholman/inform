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
        Schema::table('vpn_infos', function (Blueprint $table) {
            $table->string('mail_send')->nullable();
            $table->timestamp('time_send')->nullable();
            $table->integer('sms_access')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vpn_infos', function (Blueprint $table) {
            if (env('APP_ENV') == 'local')
            {
                $table->dropColumn('mail_send');
                $table->dropColumn('time_send');
                $table->dropColumn('sms_access');
            }
        });
    }
};
