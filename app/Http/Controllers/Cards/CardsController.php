<?php

namespace App\Http\Controllers\Cards;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoadCounterpartyInformationRequest;
use App\Http\Requests\LoadStorageLocationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class CardsController extends Controller
{
    protected CardMessagesController $messages;

    public function __construct()
    {
        if (!is_dir(storage_path() .'/app/public/card')){
            mkdir(storage_path() .'/app/public/card');
        }
        $this->messages = new CardMessagesController();
    }

    public function index(): Response
    {

        $download = false;
        $exportDateCrete  = '';
        $storageLocationDateCrete = '';
        $messages = '';

        if (file_exists(storage_path() .'/app/public/card/export.xml'))
        {
            $download = true;
            $exportDateCrete = filemtime(storage_path() .'/app/public/card/export.xml');
            if (file_exists(storage_path() .'/app/public/card/inform_export.json'))
            {
                $messages = file_get_contents(storage_path() .'/app/public/card/inform_export.json');
            }
        }

        if (file_exists(storage_path() .'/app/public/card/storageLocation.xml'))
        {
            $storageLocationDateCrete = filemtime(storage_path() .'/app/public/card/storageLocation.xml');
        }

        return response()->view('cards.index',
            [
                'download' => $download,
                'exportDateCrete' => $exportDateCrete,
                'messages' => $messages,
                'storageLocationDateCrete' => $storageLocationDateCrete
            ],
            200
        );
    }

    public function loadStorageLocation(LoadStorageLocationRequest $request): RedirectResponse
    {

        if ($request->hasFile('loadStorageLocation')) {

            $checkFileValid = new ParserStorageLocationController();
            $valid = $checkFileValid($request->file('loadStorageLocation')->get());

            if (!empty($valid)){
                Storage::putFileAs('public/card', $request->file('loadStorageLocation'), 'storageLocation.xml');
            }
        }

        return response()->redirectToRoute('card.index')->setStatusCode(302);

    }

    public function createDischarge(LoadCounterpartyInformationRequest $request): RedirectResponse
    {
        $createExportInformation = new CreateExportInformationController();
        $createExportInformation($request, $this->messages);

        file_put_contents(storage_path() .'/app/public/card/inform_export.json', json_encode($this->messages->messages));

        return response()->redirectToRoute('card.index')->setStatusCode(302);
    }
}
