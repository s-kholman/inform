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
        Schema::create('factory_gues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('factory_material_id')->constrained()->onDelete('cascade');
            $table->float('volume');
            $table->float('mechanical')->nullable()->default(0);
            $table->float('land')->nullable()->default(0);
            $table->float('haulm')->nullable()->default(0);
            $table->float('rot')->nullable()->default(0);
            $table->boolean('foreign_object')->default(false);
            $table->boolean('another_variety')->default(false);
            $table->float('sixty')->nullable()->default(0);
            $table->float('fifty')->nullable()->default(0);
            $table->float('forty')->nullable()->default(0);
            $table->float('thirty')->nullable()->default(0);
            $table->float('less_thirty')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factory_gues');
    }
};
