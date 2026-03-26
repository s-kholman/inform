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
        Schema::table('max_bot_messages', function (Blueprint $table) {
            $table->foreign('max_user_id')->references('max_user_id')->on('max_bot_users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('max_bot_messages', function (Blueprint $table) {
            $table->integer('max_user_id')->change();
        });
    }
};

