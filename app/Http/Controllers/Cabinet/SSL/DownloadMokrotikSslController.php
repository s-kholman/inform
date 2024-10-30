<?php

namespace App\Http\Controllers\cabinet\ssl;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadMokrotikSslController extends Controller
{
    /**
     * Handle the incoming request.
     */
    static function download($fileName)
    {
        Storage::put('/temp/'.$fileName.'.p12',Storage::disk('ftp')->get('/cert_export_'.$fileName.'.p12'));
    }
}
