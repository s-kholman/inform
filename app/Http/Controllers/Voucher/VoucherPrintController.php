<?php

namespace App\Http\Controllers\Voucher;

use App\Http\Controllers\Controller;
use App\Http\Requests\VoucherPrintRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use UniFi_API\Client;

class VoucherPrintController extends Controller
{
    public function index(){

        return view('voucher/print', ['voucher' => $this->voucherGet()->groupBy('note')]);

    }

    public function voucherGet()
    {
        $unifi_connection = $this->serverConnect();

        $unifi_connection->login();

        $data = $unifi_connection->stat_voucher();

        $vouchers = collect($data)->where('status' ,'==', 'VALID_ONE');


        return $vouchers;
    }

    private function serverConnect(): Client
    {
        return new Client(
            env('UniFi_USER'),
            env('UniFi_PASSWORD'),
            env('UniFi_BASEURL'),
            env('UniFi_SITE'),
            env('UniFi_VERSION'),
            env('UniFi_SSLVEREFY')
        );
    }

    public function generatePDF(VoucherPrintRequest $printRequest){

        $vouchers = $this->voucherGet()->where('note', '==', $printRequest['voucher_group'])->map(function ($values) {
            $values->code = Str::substrReplace($values->code, '-', 5, 0);
            $values->duration= $this->dayName($values->duration / 60 / 24);
            return $values;
        });

        $data = [
            'vouchers' => $vouchers
        ];

        $pdf = Pdf::loadView('voucher.pdf', $data);
        return $pdf->download('invoice.pdf');
    }

    private function dayName (int $i): string
    {
        $day = $i;

        if ($i >= 11 and $i <=14){

            return $day.' дней';

        }else{

            $i = $i % 100;

            $i = $i % 10;

            if ($i == 1) {

                return $day.' день';

            } elseif ($i >= 2 and $i <= 4) {

                return $day.' дня';

            } else {

                return $day.' дней';

            }
        }
    }
}
