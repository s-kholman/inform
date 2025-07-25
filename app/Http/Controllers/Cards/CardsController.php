<?php

namespace App\Http\Controllers\Cards;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoadCounterpartyInformationRequest;
use App\Http\Requests\LoadStorageLocationRequest;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;

class CardsController extends Controller
{
    protected CardMessagesController $messages;

    public function __construct()
    {
        $this->messages = new CardMessagesController();
    }

    public function index()
    {

        $download = false;
        $exportDateCrete = '';
        $storageLocationDateCrete = '';

        $messages = request()->cookie('cardMessages');
        Cookie::queue('cardMessages', '', -1);

        if (file_exists(storage_path() .'/app/public/card/export.xml'))
        {
            $download = true;
            $exportDateCrete = filemtime(storage_path() .'/app/public/card/export.xml');
        }
        if (file_exists(storage_path() .'/app/public/card/storageLocation.xml'))
        {
            $storageLocationDateCrete = filemtime(storage_path() .'/app/public/card/storageLocation.xml');
        }

        return view('cards.index', [
            'download' => $download,
            'exportDateCrete' => $exportDateCrete,
            'messages' => $messages,
            'storageLocationDateCrete' => $storageLocationDateCrete
        ]);
    }

    public function loadStorageLocation(LoadStorageLocationRequest $request)
    {

        if ($request->hasFile('loadStorageLocation')) {

            Storage::putFileAs('public/card', $request->file('loadStorageLocation'), 'storageLocation.xml');

        }

        return redirect()->route('card.index');

    }

    public function createDischarge(LoadCounterpartyInformationRequest $request)
    {

        $createExportInformation = new CreateExportInformationController();
        $createExportInformation($request, $this->messages);

        if (!empty($this->messages->messages)){
           Cookie::queue('cardMessages', json_encode($this->messages->messages), 1);
        }

        return redirect()->route('card.index');

    }
}
