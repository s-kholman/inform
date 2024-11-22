<?php

namespace App\Http\Controllers\Cabinet\VPN\Ikev2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadSSLMikrotik extends Controller
{
    /**
     * Handle the incoming request.
     */
    static function download(MikrotikController $mikrotikController)
    {
        Storage::put('/temp/ssl_'.$mikrotikController->sslActive[0]['name'].'.p12',Storage::disk('ftp')->get('/cert_export_'.$mikrotikController->sslActive[0]['name'].'.p12'));
    }
}
