<?php

namespace App\Http\Controllers\Voucher;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use function dd;
use function view;

class VoucherController extends Controller
{
    public function index()
    {
        return view('voucher.index', ['phone' => json_encode(Auth::user()->Registration->phone)]);
    }


}
