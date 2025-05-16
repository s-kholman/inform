<?php

namespace App\Actions\PhonePrepare;

class PhonePrepare
{
    public function __invoke(string | null $phone) : array
    {
        //Оставляем в строке только цифры
        $phoneValidate = preg_replace('~\D+~','', $phone);

        //Если 11 цифр убираем первую (может быть 7 или 8)
        if (strlen($phoneValidate) == 11){
            $phoneValidate = substr($phoneValidate, 1);
        }

        //Добавляем префикс России
        $phoneValidate = '+7' . $phoneValidate;

        //Проверяем по регулярному выражению
        if (preg_match('/^\+7\d{10}$/', $phoneValidate)){
            return ['status' => true, 'phone' => $phoneValidate];
        }

        return ['status' => false, 'phone' => ''];
    }
}
