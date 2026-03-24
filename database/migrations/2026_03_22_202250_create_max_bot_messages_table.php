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
        Schema::create('max_bot_messages', function (Blueprint $table) {
            $table->id();
            $table->integer('max_user_id');
            $table->integer('max_chat_id')->nullable();
            $table->timestamp('timestamp');
            $table->text('message');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('max_bot_messages');
    }
};
