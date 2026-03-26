<?php

namespace App\Http\Controllers\MaxBot;

use App\Http\Controllers\Controller;
use App\Models\MaxBotUser;
use BushlanovDev\MaxMessengerBot\Api;
use BushlanovDev\MaxMessengerBot\Enums\MessageFormat;
use BushlanovDev\MaxMessengerBot\Models\Attachments\Buttons\Inline\CallbackButton;
use BushlanovDev\MaxMessengerBot\Models\Attachments\Buttons\Inline\LinkButton;
use BushlanovDev\MaxMessengerBot\Models\Attachments\Buttons\Inline\RequestContactButton;
use BushlanovDev\MaxMessengerBot\Models\Attachments\Requests\InlineKeyboardAttachmentRequest;
use Illuminate\Http\Request;

class MaxBotRequestContactController extends Controller
{
    public function __invoke(MaxBotUser $maxBotUser)
    {
        $api = new Api(env('MAXBOT_ACCESS_TOKEN'));

        $api->sendMessage(
            $maxBotUser->max_user_id,
            null,
            'Добро пожаловать в бот АФ КРиММ.
            Бот не смог идентифицировать вас как сотрудника, необходимо зарегистрироваться на сайте https://inform.krimm.ru .
             При наличии регистрации нажмите кнопку "Отправить свой номер", администратор проверит данные и Вы получите доступ к функциям, при совпадении номера доступ будет открыт автоматически',
            [
                new InlineKeyboardAttachmentRequest([
                    [new RequestContactButton('Отправить свой номер!')],
                ]),
            ],
            MessageFormat::Markdown
        );
    }
}
