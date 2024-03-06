<?php

namespace App\Http\Controllers\SMS\Get;

use App\Http\Controllers\DailyUseController;
use App\Http\Requests\SMS\SmsGetRequest;
use App\Models\Sms;

class SmsGet extends DailyUseController
{
    public function smsGet(SmsGetRequest $request)
    {

        $smsGet = Sms::query()->where('smsActive', true)->where('smsType', 1)->get();
            if ($smsGet->isNotEmpty()) {
                foreach ($smsGet as $value){
                    $smsSend [$value->id] = ['phone' => $value->phone, 'text' => $value->smsText];
                    Sms::query()->where('id', $value->id)->update(['smsActive' => false]);
                }
                return $smsSend;
            }else
                return null;

    }


}
