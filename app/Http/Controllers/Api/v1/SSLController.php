<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Cabinet\SSL\MikrotikController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SSLController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $responce = new MikrotikController($request->id, $request->settings);
        return $responce->start();
    }
}
