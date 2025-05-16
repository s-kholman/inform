<?php

namespace App\Http\Controllers\SMS\ParserFactories;

use App\Http\Controllers\SMS\Send\SmsSend;
use App\Http\Controllers\Voucher\VoucherGet;
use App\Models\Sms;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use function Symfony\Component\Translation\t;

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

        if (array_key_exists(3, $smsParse)){
            $count = $smsParse[3];
        } else{
            $count = 1;
        }

        if (array_key_exists(1, $smsParse)){
            $voucherDay = $smsParse[1];
        } else{
            return $this->smsSend->send($this->sms->phone,  "Не указано количество дней");
        }

        if (array_key_exists(2, $smsParse)){
            $phone = $smsParse[2];
        } else{
            return $this->smsSend->send($this->sms->phone,  "Не указан телефон");
        }

        $validate = Validator::make(
            [
                'voucherDay' => trim($voucherDay),
                'count' => trim($count),
                'phone' => trim($phone),
            ],
            [
                'voucherDay' => 'integer|between:1,365',
                'count' => 'integer|between:1,10',
                'phone' => 'regex:/^\+7\d{10}/|max:12|min:12',
            ]
        );

        if($validate->passes()){

            return $this->getVoucher($validate->validate()['voucherDay'], $validate->validate()['phone'], $validate->validate()['count']);

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

    private function getVoucher($day, $phone, $count)
    {

        $vouchers = new VoucherGet();

        $i = 0;
        $result = '';

        $vouchers = $vouchers->get($day, $this->sms->phone, $count, $phone);

        foreach ($vouchers as $voucher){

            if($voucher['result'] == true){

                $result .= $voucher['message'] . ' ';
                $i++;

            } else {

                return $this->smsSend->send($this->sms->phone,  $voucher['message']);

            }
        }
        if($i == 1){
            $code = 'Код';
        } else {
            $code = 'Коды';
        }

        return $this->smsSend->send($phone,  "$code доступа на ". $voucher['day'] . ' к сети KRiMM_INTERNET ' . trim($result));
    }
}
