<?php

namespace App\Http\Controllers\Cabinet\SSL;

use App\Components\RouterOS\Client;
use App\Components\RouterOS\Util;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class MikrotikController extends Controller
{
    public function index()
    {
        try {
            $util = new Util($client = new Client('192.168.0.1', 'KRiMM', 'esi30fek'));
            //foreach ($util->setMenu('/log')->getAll() as $entry) {
                //echo $entry('time') . ' ' . $entry('topics') . ' ' . $entry('message') . "\n";
            //}
            dump($util->setMenu('/log')->getAll());
        } catch (Exception $e) {
            echo 'Unable to connect to RouterOS.';
        }
    }
}
