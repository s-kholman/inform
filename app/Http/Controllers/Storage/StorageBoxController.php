<?php

namespace App\Http\Controllers\Storage;

use App\Actions\StorageBox\StorageBoxCreateAction;
use App\Actions\StorageBox\StorageBoxGuesIndexAction;
use App\Actions\StorageBox\StorageBoxIndexAction;
use App\Actions\StorageBox\StorageBoxReportIndex;
use App\Actions\StorageBox\StorageBoxStoreAction;
use App\Actions\StorageBox\StorageBoxTakeIndexAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorageBoxRequest;
use App\Models\Gues;
use App\Models\StorageBox;
use App\Models\Take;
use Illuminate\Http\Request;

class StorageBoxController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(StorageBoxIndexAction $storageBoxIndexAction,
                          StorageBoxGuesIndexAction $storageBoxGuesIndexAction,
                          StorageBoxTakeIndexAction $storageBoxTakeIndexAction)
    {
        $take = $storageBoxTakeIndexAction();
        $gues = $storageBoxGuesIndexAction();
        $storage = $storageBoxIndexAction();
        $name = ['fifty' => '50+', 'forty' => '45-50', 'thirty' => '35-45', 'standard' => 'не стандарт', 'waste' => 'Отход', 'land' => 'земля'];
        return view('storagebox.index', ['storage' => $storage, 'gues' => $gues, 'name' => $name, 'take' => $take]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(StorageBoxCreateAction $storageBoxCreateAction)
    {
        $return = $storageBoxCreateAction();
        return view('storagebox.create', [
            'storage' => $return['storage'],
            'cultivation' => $return['cultivation'],
            'nomen_arr' => $return['nomen_arr'],
            'reprod_arr' => $return['reprod_arr']
        ]);
    }

    /**
     * Store a newly created resource in storagebox.
     */
    public function store(StorageBoxRequest $request, StorageBoxStoreAction $storageBoxStoreAction)
    {
        $storageBoxStoreAction($request);
        return redirect()->route('storagebox.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(StorageBox $storagebox, StorageBoxReportIndex $storageBoxReportIndex)
    {
        return view('storagebox.report.index', $storageBoxReportIndex($storagebox));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StorageBox $storagebox)
    {
        //
    }

    /**
     * Update the specified resource in storagebox.
     */
    public function update(Request $request, StorageBox $storagebox)
    {
        //
    }

    /**
     * Remove the specified resource from storagebox.
     */
    public function destroy(StorageBox $storagebox)
    {
        $storagebox->delete();
        return redirect()->route('storagebox.index');
    }
}
