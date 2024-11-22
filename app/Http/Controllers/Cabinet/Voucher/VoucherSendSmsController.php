<?php

namespace App\Http\Controllers\Cabinet\Voucher;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SMS\Send\SmsSend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class VoucherSendSmsController extends Controller
{
    private smsSend $smsSend;
    private string $message = '';

    public function __construct()
    {
        $this->smsSend = new SmsSend();
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {

        $executed = RateLimiter::attempt('sms-send', 1, function () use ($request)
        {
            $status = $this->smsSend->send($request->phone, "Код доступа на $request->day к сети KRiMM_INTERNET $request->code" );
            if ($status){
                $this->message = 'Отправлено' . ' id = ' . $status->id;
            } else{
                $this->message = 'Ошибка отправки';
            }
        });

        if (!$executed){
            $this->message = 'Превышен лимит отправки в минуту';
        }

        return ['message' => $this->message];
    }
}
