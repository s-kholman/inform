<?php

namespace App\Http\Controllers\MaxBot;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MaxBotQrCodeController extends Controller
{
    public function showQrModal(Request $request)
    {
        $description = $request->input('description', 'От сканируйте QR код');

        $imagePath = Storage::url('images/max_bot/qr/qr-example.png');

        return response()->json([
            'success' => true,
            'image_path' => $imagePath,
            'description' => $description
        ]);
    }
}
