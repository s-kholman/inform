<?php

namespace App\Http\Controllers\SMS\Get;

use App\Http\Controllers\DailyUseController;
use App\Http\Requests\SMS\SmsGetRequest;
use App\Jobs\TemperatureAlice;
use App\Models\Sms;
use Illuminate\Support\Facades\RateLimiter;

class SmsGet extends DailyUseController
{
    public function smsGet(SmsGetRequest $request)
    {
        RateLimiter::attempt('DailyUse',  1, function (){
            $this->create(); //dispatch(new DailyUse());
        },  60*60);

        RateLimiter::attempt('TemperatureAlice',  1, function (){
            dispatch(new TemperatureAlice());
        },  60*15);
        $smsSend = [];

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
