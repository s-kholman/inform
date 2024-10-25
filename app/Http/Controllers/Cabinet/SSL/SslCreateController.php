<?php

namespace App\Http\Controllers\cabinet\ssl;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SslCreateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $create = new MikrotikController($request->userID);
        $create->start();
        return redirect('/profile/show/'.Registration::query()->where('user_id', $request->userID)->get()[0]->id);
    }
}
