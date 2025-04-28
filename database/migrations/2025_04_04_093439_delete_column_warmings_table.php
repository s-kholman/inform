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
        Schema::table('warmings', function (Blueprint $table) {
            $table->dropColumn('comment_agronomist');
            $table->dropColumn('comment_deputy_director');
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
