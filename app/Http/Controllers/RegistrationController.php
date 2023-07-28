<?php

namespace App\Http\Controllers;


use App\Jobs\SendSMS;
use App\Models\Registration;
use App\Models\Sms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use UniFi_API\Client;


class RegistrationController extends Controller
{
    //Валидация, сообщения об ошибках
    private const ERROR_MESSAGES = [
        'required' => 'Заполните это поле',
        'max' => 'Значение не должно быть длинне :max символов',
        'gt' => 'Выберите из списка',
        'min' => 'Должно содержать не менее :min символов',
        'regex' => 'Должно соответствовать формату +7'
    ];
    //Валидация, задаем правила
    private const REGISTRATION_VALIDATOR = [
        'filial_name' => 'required|integer|gt:0',
        'last_name' => 'required|min:3|max:50',
        'first_name' => 'required|min:3|max:50',
        'middle_name' => 'present',
        'phone' => 'regex:/^\+7\d{10}/|max:12|min:12',
        'post_name' => 'required|integer|gt:0'
    ];

    public function profileShow(){
        if (Auth::check()){

            $user_reg = Registration::where('user_id', Auth::user()->id)->first();

            if ($user_reg){
                return view('profile', ['user_reg' => $user_reg] );
            }

        }

        return view('profile', ['user_reg' => false]);
    }

    public function storeProfile(Request $request){

        $validated = $request->validate(self::REGISTRATION_VALIDATOR,
            self::ERROR_MESSAGES);

        Registration::updateOrCreate([
            'user_id' => auth()->user()->id

        ],[
            'last_name' => $validated['last_name'],
            'first_name' => $validated['first_name'],
            'middle_name' => $validated['middle_name'],
            'filial_id' => $validated['filial_name'],
            'post_id' => $validated['post_name'],
            'phone' => $validated['phone'],
            'infoFull' => true
        ]);


        Sms::create([
            'smsText' => 'Заполненна информация по ' . $validated['last_name'] . ' ' .Str::substr($validated['first_name'], 0, 1),
            'phone' => '+79026223673',
            'smsType' => 1,
            'smsActive' => true
        ]);

        return redirect()->route('/');

    }

    public function unifi(){

        $unifi_connection = new Client('KRiMMADM', 'esi30fek', 'https://internet.krimm.ru:8443', 'default', '6.0.0', true);

        $loginresults = $unifi_connection->login();


        $voucher_result = $unifi_connection->create_voucher(60, 1,1, 'TEST');
        $vouchers = $unifi_connection->stat_voucher($voucher_result[0]->create_time);

        //$vouchers = $unifi_connection->stat_voucher(1682051188);
       // $list_guest = $unifi_connection->stat_voucher_code('9015364577');

       // $vouchers_code = Str::substrReplace($vouchers[0]->code, '-', 5, 0);

        $unifi_connection->logout();
        return view('test', ['request' => $vouchers[0]->code]);
    }
}
