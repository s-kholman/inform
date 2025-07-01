<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Cabinet\VPN\Ikev2\Initialize;
use App\Http\Controllers\Controller;
use App\Http\Requests\IkeVpnApiRequest;
use PHPUnit\Util\Exception;

class IkeVpnController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(IkeVpnApiRequest $request)
    {
        try {
            $responce = new Initialize();
            return $responce($request['id'], $request['factory'])->getMessage();
        } catch (Exception $exception){
            return ['messages' => $exception->getMessage()];
        }

    }
}
