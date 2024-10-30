<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\cabinet\ssl\CreateOrUpdateAccessUserVpnController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VpnController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $responce = new CreateOrUpdateAccessUserVpnController($request->id, $request->settings);
        return $responce();
    }
}
