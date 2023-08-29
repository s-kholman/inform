<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Storage\StorageBoxController;
use App\Http\Requests\GuesRequest;
use App\Http\Requests\GuesStoreRequest;
use App\Models\Gues;
use App\Models\StorageBox;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class GuesController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Gues::class, 'gue');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(GuesRequest $request)
    {
        $check = StorageBox::find($request->safe()->id);
        if (!empty($check)){
            return view('storagebox.gues.index', ['model' => $check]);
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
    public function store(GuesStoreRequest $request)
    {
        $valid = $request->validated();
        $full = Validator::make(
            $request->all(), [
                'full' => 'nullable'
            ]
        );
        $full->after(function ($validator) use ($request, $valid) {
            if (($valid['fifty']+$valid['forty']+$valid['thirty']+$valid['standard']+$valid['waste']+$valid['land']) !== 100 ) {
                $validator->errors()->add('full', 'Сумма по полям должна равняться 100');
            }
        });
        $full->validate();
        Gues::create([
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
    public function show(Gues $gue)
    {
        return view('storagebox.gues.destroy', ['gue' => $gue]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gues $gues)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gues $gue)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gues $gue)
    {
        $gue->delete();
        return redirect()->route('storagebox.show', ['storagebox' => $gue->storage_box_id]);
    }
}
