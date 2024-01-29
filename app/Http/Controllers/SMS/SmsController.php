<?php

namespace App\Http\Controllers\SMS;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SMS\ParserFactories\SmsParser;
use App\Http\Controllers\SMS\Send\SmsSend;
use App\Http\Requests\SMS\SmsInRequest;
use App\Models\Sms;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SmsController extends Controller
{

    public function smsIn(SmsInRequest $request): Builder|Model
    {
            $sms = Sms::query()
                ->create(
                    [
                        'smsText' => substr(htmlspecialchars(Str::upper($request->text)), 0, 100),
                        'phone' => $request->phone,
                        'smsType' => 2,
                        'smsActive' => true
                    ]);

                $smsParser = new SmsParser($sms);

                return $smsParser->smsParser();
    }
}
