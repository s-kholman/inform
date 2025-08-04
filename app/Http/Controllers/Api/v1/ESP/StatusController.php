<?php

namespace App\Http\Controllers\Api\v1\ESP;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StatusController extends Controller
{
    public function __invoke(Request $request)
    {
        Log::notice($request->post());
        return response()->json(['id' => 'id']);
    }
}
