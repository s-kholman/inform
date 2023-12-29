<?php

namespace App\Http\Controllers;

use App\Models\SowingType;
use Illuminate\Http\Request;

class SowingTypeController extends Controller
{
    public function index()
    {
        return view('sowing.type.index');
    }

    public function store(Request $request)
    {
        SowingType::query()->create(
            [
                'name' => $request->name,
                'no_machine' => !boolval($request->no_machine),
            ]
        );
        return redirect()->route('type.index');
    }

    public function show(SowingType $type)
    {
        return view('sowing.type.show', ['type' => $type]);
    }

    public function update(Request $request, SowingType $type)
    {
        $type->update(
                [
                    'name' => $request->name,
                    'no_machine' => !boolval($request->no_machine),
                ]
            );
        return redirect()->route('type.index');
    }

    public function destroy(SowingType $type)
    {
        $type->delete();
    return redirect()->route('type.index');
    }
}
