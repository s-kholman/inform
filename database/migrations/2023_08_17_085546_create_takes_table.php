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
        Schema::create('takes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('storage_box_id')->constrained();
            $table->float('fifty')->nullable()->default(0);
            $table->float('forty')->nullable()->default(0);
            $table->float('thirty')->nullable()->default(0);
            $table->float('standard')->nullable()->default(0);
            $table->float('waste')->nullable()->default(0);
            $table->float('land')->nullable()->default(0);
            $table->date('date');
            $table->foreignId('user_id')->constrained();
            $table->string('comment', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('takes');
    }
};
