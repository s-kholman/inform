<?php

namespace App\Http\Controllers;

use App\Models\Counterparty;
use Illuminate\Http\Request;

class CounterpartyController extends Controller
{
    private const ERROR_MESSAGES = [
        'required' => 'Заполните это поле',
        'max' => 'Значение не должно быть длинне :max символов'
    ];

    private const ADD_VALIDATOR = [
        'counterparty' => 'required|max:255',
    ];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('sokar.counterparty');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storagebox.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(self::ADD_VALIDATOR, self::ERROR_MESSAGES);
        Counterparty::create(['name'=>$validated['counterparty']]);
        return redirect('counterparty');
    }

    /**
     * Display the specified resource.
     */
    public function show(Counterparty $counterparty)
    {
        return view('sokar.counterparty_show', ['counterparty' => $counterparty]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Counterparty $counterparty)
    {
        //
    }

    /**
     * Update the specified resource in storagebox.
     */
    public function update(Request $request, Counterparty $counterparty)
    {
        $validated = $request->validate(self::ADD_VALIDATOR, self::ERROR_MESSAGES);
        $counterparty->update(['name' => $validated['counterparty']]);
        return redirect('counterparty');
    }

    /**
     * Remove the specified resource from storagebox.
     */
    public function destroy(Counterparty $counterparty)
    {
        $counterparty->delete();
        return redirect('counterparty');
    }
}
