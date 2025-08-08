<?php

namespace App\Http\Controllers\Api\v1\ESP;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ConfirmationController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        Log::info($request->post());
        return response()->json(
            [
                'status' => true,
            ]
        )->setStatusCode(200);
    }
}
