<?php

namespace App\Http\Controllers;

use App\Models\StorageMode;


class StorageModeController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(StorageMode::class, 'mode');
    }

    public function show(StorageMode $mode)
    {
        return view('production_monitoring.mode.delete', ['mode' => $mode]);
    }

    public function destroy(StorageMode $mode)
    {
        $mode->delete();
        return redirect()->route('monitoring.show.filial.all', $mode->StorageName->storage_name_id);
    }
}
