<?php

namespace App\Http\Controllers\Voucher;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SMS\Send\SmsSend;
use App\Http\Requests\VoucherGetToSendRequest;

class VoucherGetToSendController extends Controller
{
    private VoucherGet $voucherGet;

    private SmsSend $smsSend;

    public function __construct()
    {
        $this->voucherGet = new VoucherGet();
        $this->smsSend = new SmsSend();
    }

    public function __invoke(VoucherGetToSendRequest $request)
    {

        $vouchers = $this->voucherGet->get($request->day, $request->phone, 1, $request->phone, true);

        $status = '';

        foreach ($vouchers as $voucher){

            if($voucher['result'] == true){

                $status =  $this->smsSend->send($request->phone,  'Доступ на '. $voucher['day'] . ' к сети KRiMM_INTERNET ' . $voucher['message']);

            } else {

                $status = $this->smsSend->send('+79026223673',  'Ошибка отправки с сайта: ' . $voucher['message']);

            }
        }

        return ['message' => $this->status($status)];
    }

    private function status($status)
    {
        if ($status){
            return 'Создана запись для отправки SMS id = ' . $status->id;
        } else{
            return 'Ошибка отправки';
        }
    }
}
