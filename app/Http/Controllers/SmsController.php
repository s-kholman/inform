<?php

namespace App\Http\Controllers;

use App\Jobs\DailyUse;
use App\Models\PhoneLimit;
use App\Models\Registration;
use App\Models\Sms;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use UniFi_API\Client;
class SmsController extends Controller
{
    private const SMSWIFI_VALIDATOR = [
        'phone' => 'regex:/^\+7\d{10}/|max:12|min:12',
        'smsType' => 'in:WIFI',
        'vaucherDay' => 'integer|between:1,365',
        'smsComment' => 'nullable|string|max:100'];
    private const GETVOUCHER_VALIDATOR = [
        'phone' => 'required',
        'email' => 'required',
        'voucherDay' => 'integer|between:1,365',
        'voucherCount' => 'integer|between:1,3',
        'comment' => 'nullable|string|max:100'
    ];

    private const GETVOUCHER_ERROR = [
        'voucherDay.integer' => 'Только целое число',
        'voucherDay.between' => 'От 1 до 365',
        'comment.max' => 'Не может привышать :max символов ',

    ];

    const SMSGET = 1;
    const SMSIN = 2;

    public function smsGet (Request $request){
        /**
         * RateLimiter - ограничение запросов
         */
        RateLimiter::attempt('DailyUse',  1, function (){
            dispatch(new DailyUse());
            return null;
        },  60*60);

        if ($request->token == env('SMS_TOKEN') AND $request->type == 'get_sms'){
            if (Sms::where('smsActive', true)->where('smsType', self::SMSGET)->count()) {
                foreach (Sms::where('smsActive', true)->where('smsType', self::SMSGET)->get() as $value){
                    $smsSend [$value->id] = ['phone' => $value->phone, 'text' => $value->smsText];
                    Sms::where('id', $value->id)->update(['smsActive' => false]);
                }
                return $smsSend;
            }else
                return null;
        } else
           return null;
    }

    public function smsIn (Request $request){

        if ($request->token ==  env('SMS_TOKEN') AND Str::length($request->phone) == 12){
            Sms::create([
                'smsText' => substr(htmlspecialchars(Str::upper($request->text)),0,100),
                'phone' => $request->phone,
                'smsType' => self::SMSIN,
                'smsActive' => true]);
        }
        self::smsParser();
    }

    /**
     * Парсинг входящих СМС
     * 1. Смотрим если вообще что парсить
     * 2. Запускаем цикл
     * 3. Проверяем что в СМС запрос на WiFi (должно быть до первого пробела, регистр не важен)
     * 4. Проверяем что запросивший номер имеет право (номер есть в регистрации на сайте и учетка вктивированна администратором)
     * 4.1 И (или) данная симка зарегистрированна как корпоративная
     * 5. Проверяем сколько дней запросил пользователь если не более года (365 дней), отправляем на генерацию запроса
     * 6. Создаем запись для отправки ответной СМС с полученным кодом
     */

    private function smsParser (){

        $smsCount = Sms::where('smsActive', true)->where('smsType', self::SMSIN)->count();
        if ($smsCount) {
            foreach (Sms::where('smsActive', true)->where('smsType', self::SMSIN)->get() as $value){
                $validator = Validator::make([
                    'phone' => $value->phone,
                    'smsType' => Str::before($value->smsText, ' '),
                    'vaucherDay' => Str::of($value->smsText)->replaceFirst('WIFI ', '')->before(' ')->value(),
                    'smsComment' => Str::of($value->smsText)->replaceFirst('WIFI ', '')->after(' ')->value()
                ], self::SMSWIFI_VALIDATOR); //Валидация данных

                if ($validator->passes() && (Registration::where('phone', $value->phone)->where('activation', true)->count() or
                        PhoneLimit::where('phone', Str::after($value->phone, '+'))->where('active', true)->count() )){
                    $validated = $validator->validated(); //Валидированные данные
                    $voucher = self::unifi($validated['vaucherDay'], $validated['phone'], 'SMS');
                    if ($voucher <> ''){
                        Sms::create([
                            'smsText' => 'Доступ на '. self::dayName($validated['vaucherDay']) . ' к сети KRiMM_INTERNET ' . $voucher,
                            'phone' => $value->phone,
                            'smsType' => self::SMSGET,
                            'smsActive' => true
                        ]);
                    }
                } else {
                    Sms::create([
                        'smsText' => 'Номер '.$value->phone.' в БД не найден, обратитесь к администратору',
                        'phone' => $value->phone,
                        'smsType' => self::SMSGET,
                        'smsActive' => true
                    ]);
                }
                Sms::where('id', $value->id)->update(['smsActive' => false]);

            }
        }
        return null;
    }

    private function dayName ($i){
        $day = $i;
        if ($i >= 11 and $i <=14){
            return $day.' дней';
        }else{
            $i = $i % 100;
            $i = $i % 10;
            if ($i == 1) {
                return $day.' день';
            } elseif ($i >= 2 and $i <= 4) {
                return $day.' дня';
            } else {
                return $day.' дней';
            }
        }
    }

    private function unifi($day, $phone, $type){

        $unifi_connection = new Client('KRiMMADM', 'esi30fek', 'https://internet.krimm.ru:8443', 'default', '6.0.0', true);

        $loginresults = $unifi_connection->login();


        $voucher_result = $unifi_connection->create_voucher($day*60*24, 1,1, $phone);
        $vouchers = $unifi_connection->stat_voucher($voucher_result[0]->create_time);

        if ($type == 'SMS'){
            return Str::substrReplace($vouchers[0]->code, '-', 5, 0);
        } elseif ($type == 'SAIT'){

            return ['code' => $vouchers[0]->code, 'create_time' => $vouchers[0]->create_time];
        }
        else {
            return null;
        }
    }

    public function voucherGetShow(){
        return view('/voucher_get');
    }

    public function voucherGet(Request $request){
        $validate = $request->validate(self::GETVOUCHER_VALIDATOR, self::GETVOUCHER_ERROR);
        $voucher = self::unifi( $validate['voucherDay'], $validate['phone'], 'SAIT');
        Voucher::create([
            'phone' => $validate['phone'],
            'create_time' => $voucher['create_time'],
            'voucher_code' => $voucher['code'],
            'voucher_day' => $validate['voucherDay'],
            'voucher_use' => false,
            'comment' => $validate['comment']
        ]);
        return redirect()->route('voucher');
    }
}
