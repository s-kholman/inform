<?php

namespace App\Http\Controllers\Api\v1\MaxBot;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MaxBotWebHookController extends Controller
{
    public function __invoke(Request $request)
    {
        Log::info('WebHook');
        Log::info('MAX = ' . $request->post() );
        // TODO: Implement __invoke() method.
    }
}
