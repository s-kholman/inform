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

        Schema::table('product_monitorings', function (Blueprint $table) {
            $table->foreignId('harvest_year_id')->default($this->id->HarvestYear(now()))->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_monitorings', function (Blueprint $table) {
            $table->dropColumn('harvest_year_id');
        });
    }
};
