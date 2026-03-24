<?php

namespace App\Http\Controllers\MaxBot;

use App\Http\Controllers\Controller;
use App\Models\MaxBotUser;
use BushlanovDev\MaxMessengerBot\Api;
use BushlanovDev\MaxMessengerBot\Enums\MessageFormat;
use Illuminate\Http\Request;

class MaxBotSendMessageController extends Controller
{
    public function __invoke(MaxBotUser $maxBotUser, string $message)
    {
        $api = new Api(env('MAXBOT_ACCESS_TOKEN'));

        $api->sendMessage(
            $maxBotUser->max_user_id,
            null,
            $message, // Текст сообщения, вы можете использовать HTML или Markdown
            null,
            MessageFormat::Markdown // Формат сообщения (Markdown или HTML)
        );
    }
}
