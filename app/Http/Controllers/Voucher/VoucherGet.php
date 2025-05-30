<?php

namespace App\Http\Controllers\Voucher;


use App\Actions\Declension\DeclensionWord;
use App\Http\Controllers\SMS\PhoneAuth\PhoneAuth;
use App\Http\Controllers\SMS\Send\SmsSend;
use Illuminate\Support\Str;
use UniFi_API\Client;

class VoucherGet
{
    private PhoneAuth $phoneAuth;

    private SmsSend $smsSend;

    public function __construct()
    {
        $this->phoneAuth = new PhoneAuth();

        $this->smsSend = new SmsSend();
    }

    public function get(int $day, $phone, $count = 1, $note = '', bool $check = false): array
    {

        if ($this->phoneAuth->phoneAuth($phone, $check)){

            $unifi_connection = new Client(
                env('UniFi_USER'),
                env('UniFi_PASSWORD'),
                env('UniFi_BASEURL'),
                env('UniFi_SITE'),
                env('UniFi_VERSION'),
                env('UniFi_SSLVEREFY')
            );

            try {
                $unifi_connection->login();

                $voucher_result = $unifi_connection->create_voucher($day*60*24, $count,1, $note);

                $vouchers = $unifi_connection->stat_voucher($voucher_result[0]->create_time);

                $declensionWord = new DeclensionWord();

                foreach ($vouchers as $voucher){

                    $result [$voucher->_id] = [
                        'message' => Str::substrReplace($voucher->code, '-', 5, 0),
                        'result' => true,
                        'day' => $declensionWord($day, 'день', 'дня', 'дней')];

                }

                return $result;

            } catch (\Throwable $e){

                $this->smsSend->send('+79026223673',  "Сервер UniFi не отвечает");

                $result [0] = ['message' => 'Сервер не отвечает, попробуйте позже', 'result' => false];

                return $result;

            }

        } else{

            $this->smsSend->send('+79026223673',  "Запрос с неизвестного номера - $phone");

            $result [0] = ['message' => 'Номер телефона не подтвержден администратором', 'result' => false];

            return $result;
        }
    }
}
