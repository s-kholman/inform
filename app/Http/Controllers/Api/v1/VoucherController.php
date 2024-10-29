<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\VoucherGetResource;
use App\Mail\VoucherCreateMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use UniFi_API\Client;

class VoucherController extends Controller
{
    public function voucherCreate(Request $request)
    {
        $unifi_connection = $this->serverConnect();

        $unifi_connection->login();

        $unifi_connection->create_voucher($request->day*60*24, 1,1, $request->phone);

        Mail::to('sergey@krimm.ru', 'Администратор')->queue(new VoucherCreateMail($request->phone));
    }

    public function voucherGet(Request $request): VoucherGetResource
    {
        $unifi_connection = $this->serverConnect();

        $unifi_connection->login();

        $data = $unifi_connection->stat_voucher();

        $vouchers = collect($data)->where('note', '==', $request->phone);
        return new VoucherGetResource(
            $vouchers
        );
    }

    private function serverConnect()
    {
        $unifi_connection = new Client(
            env('UniFi_USER'),
            env('UniFi_PASSWORD'),
            env('UniFi_BASEURL'),
            env('UniFi_SITE'),
            env('UniFi_VERSION'),
            env('UniFi_SSLVEREFY')
        );
        return $unifi_connection;
    }
}
