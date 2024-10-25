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
        Schema::create('vpn_infos', function (Blueprint $table) {
            $table->ipAddress('ip_domain')->nullable();
            $table->string('login_domain', 255)->nullable();
            $table->string('revoke_friendly_name', 255)->nullable();
            $table->foreignId('registration_id')->constrained();
            $table->id();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vpn_infos');
    }
};
