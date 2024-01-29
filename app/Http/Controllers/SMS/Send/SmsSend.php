<?php

namespace App\Http\Controllers\SMS\Send;

use App\Models\Sms;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class SmsSend
{
    public function send($phone, $message): Model|Builder
    {
        return Sms::query()->
        create([
            'smsText' => $message,
            'phone' => $phone,
            'smsType' => 1,
            'smsActive' => true
        ]);
    }

}
