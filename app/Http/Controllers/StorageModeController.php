<?php

namespace App\Http\Controllers;

use App\Actions\harvest\HarvestAction;
use App\Models\StorageMode;
use Illuminate\Support\Facades\Auth;


class StorageModeController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(StorageMode::class, 'mode');
    }

    public function show(StorageMode $mode, HarvestAction $harvestAction)
    {
        return view('production_monitoring.mode.delete', ['mode' => $mode, 'harvest_year_id' => $harvestAction->HarvestYear($mode->created_at)]);
    }

    public function destroy(StorageMode $mode, HarvestAction $harvestAction)
    {
        $mode->delete();
        return redirect()->route('monitoring.show.filial.all', ['storage_name_id' => $mode->StorageName->storage_name_id, 'harvest_year_id' => $harvestAction->HarvestYear($mode->created_at)]);
    }
}
