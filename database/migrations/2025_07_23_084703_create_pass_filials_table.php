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
        Schema::create('pass_filials', function (Blueprint $table) {
            $table->uuid('id')->primary()->index();
            $table->text('number_car');
            $table->text('last_name')->nullable();
            $table->foreignId('user_id');
            $table->foreignId('filial_id');
            $table->boolean('printed');
            $table->date('date');
            $table->text('comments')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pass_filials');
    }
};
