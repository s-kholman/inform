<?php

namespace App\Http\Controllers\SMS\ParserFactories;

use App\Http\Controllers\SMS\PhoneAuth\PhoneAuth;
use App\Http\Controllers\SMS\Send\SmsSend;
use App\Http\Controllers\Voucher\VoucherGet;
use App\Models\Sms;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class WIFIFactory implements SmsParserInterface
{

    private Sms $sms;

    private SmsSend $smsSend;

    public function __construct($sms)
    {
        $this->sms = $sms;
        $this->smsSend = new SmsSend();
    }

    public function smsBody()
    {

        $validate = Validator::make(
            [
                'voucherDay' => Str::of($this->sms->smsText)->replaceFirst(Str::before($this->sms->smsText, ' ').' ', '')->before(' ')->value()
            ],
            [
                'voucherDay' => 'integer|between:1,365',
            ]
        );

        if($validate->passes()){

            return $this->getVoucher($validate->validate()['voucherDay'], $this->sms->phone);

        } else {

            return $this->smsSend->send($this->sms->phone,  "Время доступа указанно не корректно, доступно от 1 до 365");

        }
    }

    public function smsComment()
    {
        return Str::of($this->sms->smsText)->replaceFirst(Str::before($this->sms->smsText, ' ').' ', '')->after(' ')->value();
    }


    public function render(): Builder|Model
    {
        $phoneAuth = new PhoneAuth();

        if ($phoneAuth->phoneAuth($this->sms->phone)){

            return $this->smsBody();

        } else {

            return $this->smsSend->send($this->sms->phone, 'Номер телефона не подтвержден администратором');

        }
    }

    private function getVoucher($day, $phone)
    {
        $voucher = new VoucherGet();

        $voucher = $voucher->get($day, $phone);

        if($voucher <> null){

            return $this->smsSend->send($this->sms->phone,  'Доступ на '. $this->dayName($day) . ' к сети KRiMM_INTERNET ' . $voucher,);

        } else {

            return $this->smsSend->send($this->sms->phone,  "Ошибка, код не получен");

        }

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
