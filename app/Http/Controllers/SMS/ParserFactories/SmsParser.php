<?php

namespace App\Http\Controllers\SMS\ParserFactories;

use App\Http\Controllers\SMS\Send\SmsSend;
use App\Models\Sms;
use Illuminate\Support\Str;


class SmsParser extends AbstractSmsParser
{

    private Sms $sms;

    private SmsSend $smsSend;

    public function __construct(Sms $sms)
    {
        $this->sms = $sms;
        $this->smsSend = new SmsSend();
    }

    public function smsParser()
    {

        $name_class = '\App\Http\Controllers\SMS\ParserFactories\\' .Str::before($this->sms->smsText, ' ') . 'Factory';

        if (class_exists($name_class)) {

            $class = new $name_class($this->sms);

            return $class->render();

        } else{

           return $this->smsSend->send($this->sms->phone, 'Шаблон SMS не определен');

        }
    }
}
