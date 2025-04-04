<?php

use App\Actions\harvest\HarvestAction;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public $id;

    public function __construct()
    {
        $this->id = new HarvestAction();
    }
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('warmings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('storage_name_id');
            $table->integer('volume');
            $table->date('warming_date');
            $table->date('sowing_date');
            $table->string('comment')->nullable();
            $table->string('comment_agronomist')->nullable();
            $table->string('comment_deputy_director')->nullable();
            $table->foreignId('harvest_year_id')->default($this->id->HarvestYear(now()))->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warmings');
    }
};
