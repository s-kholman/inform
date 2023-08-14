<?php

namespace App\Http\Controllers;

use App\Actions\Printer\device\DeviceIndexAction;
use App\Actions\Printer\device\DeviceСreateAction;
use App\Http\Requests\DeviceRequest;
use App\Models\Device;
use Illuminate\Http\Request;


class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(DeviceIndexAction $deviceIndexAction)
    {
        return view('printer.device.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('printer.device.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DeviceRequest $request, DeviceСreateAction $deviceСreateAction)
    {
        $deviceСreateAction($request);

        return redirect()->route('device.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Device $device)
    {
        return view('printer.device.show', ['device' => $device]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Device $device)
    {
        return view('printer.device.edit', ['device' => $device]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Device $device)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Device $device)
    {
        $device->delete();

        return redirect()->route('device.index');
    }
}
