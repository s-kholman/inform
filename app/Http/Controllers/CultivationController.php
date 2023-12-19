<?php

namespace App\Http\Controllers;

use App\Models\Cultivation;
use Illuminate\Http\Request;

class CultivationController extends Controller
{
    public function index()
    {

        $cultivation = Cultivation::all();
        return view('cultivation.index', ['cultivation' => $cultivation]);
    }

    public function edit(Cultivation $cultivation)
    {
        return view('cultivation.edit', ['cultivation' => $cultivation]);
    }

    public function update(Request $request, Cultivation $cultivation)
    {

        $cultivation->update(
            [
                'name' => $request->cultivation,
                'sowing_type_id' => $request->sowing_type,
                'color' => $request->color,
            ]
        );

        return redirect()->route('cultivation.index');
    }

    public function show(Cultivation $cultivation)
    {
        dd('show');
    }

    public function store(Request $request)
    {
        Cultivation::query()
            ->create(
                [
                    'name' => $request->cultivation,
                    'sowing_type_id' => $request->sowing_type,
                    'color' => $request->color,
                ]
            );
        return redirect()->route('cultivation.index');
    }

    public function destroy(Cultivation $cultivation)
    {
        try {
            $cultivation->delete();
        } catch (QueryException $e) {
            return redirect()->route('cultivation.index');
        }
        return redirect()->route('cultivation.index');
    }
}
