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
        Schema::dropIfExists('posevs');
        Schema::dropIfExists('svyazs');
        Schema::dropIfExists('sutkis');
        Schema::dropIfExists('kulturas');
        Schema::dropIfExists('vidposevas');
        Schema::dropIfExists('agregats');
        Schema::dropIfExists('fios');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
