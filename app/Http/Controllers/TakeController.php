<?php

namespace App\Http\Controllers;

use App\Actions\StorageBox\StorageBoxTakeSumAction;
use App\Http\Controllers\Storage\StorageBoxController;
use App\Http\Requests\TakeRequest;
use App\Http\Requests\TakeStoreRequest;
use App\Models\StorageBox;
use App\Models\Take;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Facades\Validator;

class TakeController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Take::class, 'take');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(TakeRequest $request, StorageBoxTakeSumAction $storageBoxTakeSumAction)
    {
        $storageBox = StorageBox::find($request->safe()->id);
        if (!empty($storageBox)){
            return view('storagebox.take.index', ['model' => $storageBox, 'volume' => $storageBoxTakeSumAction($storageBox)]);
        } else {
            return redirect()->route('storagebox.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TakeStoreRequest $request)
    {
        $valid = $request->validated();
        $full = Validator::make(
            $request->all(), [
                'full' => 'nullable'
            ]
        );

        $full->after(function ($validator) use ($request, $valid) {
            if (intval(($valid['max'] - ($valid['fifty']+$valid['forty']+$valid['thirty']+$valid['standard']+$valid['waste']+$valid['land']+$valid['volume']))) <= -1 ) {
               $validator->errors()->add('full', 'Сумма по полям привышает остаток');
            }
        });
        $full->validate();

        Take::create([
            'storage_box_id' => $valid['storage_box_id'],
            'fifty' => $valid['fifty'],
            'forty' => $valid['forty'],
            'thirty' => $valid['thirty'],
            'standard' => $valid['standard'],
            'waste' => $valid['waste'],
            'land' => $valid['land'],
            'date' => $valid['date'],
            'user_id' => Auth::user()->id,
            'comment' => $valid['comment']
        ]);
       return redirect()->action([StorageBoxController::class, 'show'], ['storagebox' => $valid['storage_box_id']])->with('message', 'Данные добавленны');
    }

    /**
     * Display the specified resource.
     */
    public function show(Take $take)
    {
        return view('storagebox.take.destroy', ['take' => $take]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Take $take)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Take $take)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Take $take)
    {
        $take->delete();
        return redirect()->route('storagebox.show', ['storagebox' => $take->storage_box_id]);
    }
}
