<?php

namespace App\Http\Controllers\SMS\ParserFactories;

use App\Http\Controllers\SMS\Send\SmsSend;
use App\Http\Controllers\Voucher\VoucherGet;
use App\Models\Sms;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SENDFactory implements SmsParserInterface
{
    private Sms $sms;

    private SmsSend $smsSend;

    public function __construct(Sms $sms)
    {
        $this->sms = $sms;
        $this->smsSend = new SmsSend();
    }

    /**
     * @inheritDoc
     */
    public function smsBody()
    {

        $smsParse = explode(' ', $this->sms->smsText, 4);

        if (!empty($smsParse[3]) && array_key_exists($smsParse[3], $smsParse)){
            $count = $smsParse[3];
        } else{
            $count = 1;
        }

        if (!empty($smsParse[1]) && array_key_exists($smsParse[1], $smsParse)){
            $voucherDay = $smsParse[1];
        } else{
            return $this->smsSend->send($this->sms->phone,  "SMS не прошло валидацию");
        }

        if (!empty($smsParse[2]) && array_key_exists($smsParse[2], $smsParse)){
            $phone = $smsParse[2];
        } else{
            return $this->smsSend->send($this->sms->phone,  "SMS не прошло валидацию");
        }

        $validate = Validator::make(
            [
                'voucherDay' => $voucherDay,
                'count' => $count,
                'phone' => $phone,
            ],
            [
                'voucherDay' => 'integer|between:1,365',
                'count' => 'integer|between:1,10',
                'phone' => 'regex:/^\+7\d{10}/|max:12|min:12',
            ]
        );

        if($validate->passes()){

            return $this->getVoucher($validate->validate()['voucherDay'], $validate->validate()['phone']);

        } else {

            return $this->smsSend->send($this->sms->phone,  "SMS не прошло валидацию");

        }
    }

    /**
     * @inheritDoc
     */
    public function smsComment()
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function render(): Builder|Model|bool
    {


        if ('+79026223673' === $this->sms->phone){

            return $this->smsBody();

        } else {

            return $this->smsSend->send($this->sms->phone, 'Опция только для администратора');

        }
    }

    private function getVoucher($day, $phone)
    {
        $smsParse = explode(' ', $this->sms->smsText, 4);

        $vouchers = new VoucherGet();

        $vouchers = $vouchers->get($day, $phone, $smsParse[3]);

        foreach ($vouchers as $voucher){

            if($voucher['result'] == true){

                return $this->smsSend->send($phone,  'Доступ на '. $voucher['day'] . ' к сети KRiMM_INTERNET ' . $voucher['message'],);

            } else {

                return $this->smsSend->send($this->sms->phone,  $voucher['message']);

            }
        }
    }
}
