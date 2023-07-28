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
        Schema::create('disassemblies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('box_id')->constrained()->onDelete('cascade');
            $table->float('f50')->nullable();
            $table->float('f40')->nullable();
            $table->float('f30')->nullable();
            $table->float('notStandart')->nullable();
            $table->float('waste')->nullable();
            $table->float('land')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disassemblies');
    }
};
