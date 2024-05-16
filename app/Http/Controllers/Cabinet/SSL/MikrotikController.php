<?php

namespace App\Http\Controllers\Cabinet\SSL;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RouterOS\Client;
use RouterOS\Config;
use RouterOS\Query;


class MikrotikController extends Controller
{

    public function index()
    {
        $client  = new Client(
            [
                'host' => '192.168.0.235',
                'user' => 'KRiMM',
                'pass' => 'esi30fek',
                'port' => 8728
            ]
        );/*
// Create "where" Query object for RouterOS
        $query =
            (new Query('/certificate/print'))
                //->where('serial-number', '5B065DA5CBCA9CB7')
                //->where('type', 'vlan')
                ->operations('|');
        $query =
            (new Query('/certificate/find'))
                ->where('name', 's_kholman_20213')
                //->where('type', 'vlan')
                ->operations('|');

// Send query and read response from RouterOS

        $response = $client->query($query)->read();
        dump($response);
        $find = collect($response)->where('name', 's_kholman_2021');
        dd($find);*/

        $API = new \RouterosAPI();





       dd($API->connect('192.168.0.235', 'KRiMM', 'esi30fek'));

    }


}
