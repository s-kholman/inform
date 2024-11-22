<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\cabinet\ssl\CreateOrUpdateAccessUserVpnController;
use App\Http\Controllers\Cabinet\VPN\Ikev2\Initialize;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IkeVpnController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $responce = new Initialize();
        return $responce($request->id, $request->factory);
    }
}
