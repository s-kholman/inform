<?php

namespace App\Http\Controllers\Cabinet\VPN\Ikev2;

use Exception;
use PHPUnit\Event\Code\Throwable;

class ExceptionInform extends Exception
{
    public function __construct($message, $code = 0, Throwable $previous = null) {
        // Какой-то код

        // Убедимся, что родительский класс правильно присвоил значения
        parent::__construct($message, $code, $previous);
    }

    // Переопределим строковое представление объекта
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
