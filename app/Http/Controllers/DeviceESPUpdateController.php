<?php

namespace App\Http\Controllers;

use App\Models\DeviceESPUpdate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class DeviceESPUpdateController extends Controller
{
    public function index(): Response
    {
        return response()->view('esp.loadUpdateBin');
    }

    public function store(Request $request)
    {
        if ($request->hasFile('fileBin')) {

           // $checkFileValid = new ParserStorageLocationController();
            //$valid = $checkFileValid($request->file('loadStorageLocation')->get());
            $valid = $request->file('fileBin')->get();

            if (!empty($valid)){
            $storage = Storage::putFileAs('public/esp/update', $request->file('fileBin'),
                    'temperature_v.'.
                            $request->versionBin .
                            '_' .
                            Carbon::parse($request->compileDateBin)->format('d.m.Y') .
                            '.bin');
            }
        }

        $path = url('/'). '/storage' . substr($storage, 6);

        DeviceESPUpdate::query()
            ->create(
                [
                    'date' => $request->compileDateBin,
                    'url' => $path,
                    'version' => $request->versionBin,
                    'description' => $request->descriptionBin,
                ]
            );


        return response()->redirectToRoute('esp.upload.bin.index')->setStatusCode(302);
    }
}
