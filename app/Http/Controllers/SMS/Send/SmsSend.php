<?php

namespace App\Http\Controllers\SMS\Send;

use App\Models\Sms;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class SmsSend
{
    public function send($phone, $message): Model|Builder|bool
    {
        if($this->phoneValidate($phone) && $this->messageLength($message)){

            try {

                return Sms::query()->
                create([
                    'smsText' => $message,
                    'phone' => $phone,
                    'smsType' => 1,
                    'smsActive' => true
                ]);

            } catch (\Throwable $e) {

                return false;

            }

        } else {

            return false;

        }

    }

    private function phoneValidate($phone) : bool
    {
        return preg_match('/^\+7\d{10}/', $phone);
    }

    private function messageLength($message) : bool
    {
        if(strlen($message) <= 100) {

            return true;

        } else {

            return false;

        }
    }
}



