<?php

namespace App\Http\Controllers\Voucher;


use App\Http\Controllers\SMS\PhoneAuth\PhoneAuth;
use Illuminate\Support\Str;
use UniFi_API\Client;

class VoucherGet
{
    private PhoneAuth $phoneAuth;

    public function __construct()
    {
        $this->phoneAuth = new PhoneAuth();
    }

    public function get(int $day, $phone, $count = 1): array
    {

        if ($this->phoneAuth->phoneAuth($phone)){

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

                $voucher_result = $unifi_connection->create_voucher($day*60*24, $count,1, $phone);

                $vouchers = $unifi_connection->stat_voucher($voucher_result[0]->create_time);

                return ['message' => Str::substrReplace($vouchers[0]->code, '-', 5, 0), 'key' => true];

            } catch (\Throwable $e){

                return ['message' => 'Server не отвечает, попробуйте позже', 'key' => false];

            }

        } else{

            return ['message' => 'Номер телефона не подтвержден администратором', 'key' => false];

        }

    }
}