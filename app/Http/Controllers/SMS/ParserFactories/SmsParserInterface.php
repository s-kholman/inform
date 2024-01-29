<?php

namespace App\Http\Controllers\SMS\ParserFactories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface SmsParserInterface
{
    /**
     * Получаем тело SMS, заголовок получаем при передачи в фабрику
     * Соответственно в фабрике выполняем наше действие
     */
    public function smsBody();

    /**
     * Шаблон SMS подразумевает
     * 1 - тип (отвечает какая фабрика будет обрабатывать)
     * 2 - тело, какое (какие) действия предпринимаем
     * 3 - комментарий, для гибкости
     */
    public function smsComment();

    /**
     *
     *
     */
    public function render():Builder|Model;

}
