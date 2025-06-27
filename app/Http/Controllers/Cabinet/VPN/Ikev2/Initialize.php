<?php

namespace App\Http\Controllers\Cabinet\VPN\Ikev2;


use App\Models\User;

class Initialize
{
    public function __invoke($id, $factory)
    {
        $name_class = '\App\Http\Controllers\Cabinet\VPN\Ikev2\\' .$factory;
        if (class_exists($name_class)) {
            $class = new $name_class(User::query()->find($id));
            return $class->render();
        } else{
            return ['message' => 'Ошибка фабрики, не найден класс'];
        }
    }
}
