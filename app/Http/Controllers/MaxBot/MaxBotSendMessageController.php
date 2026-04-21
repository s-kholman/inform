<?php

namespace App\Http\Controllers\MaxBot;

use App\Http\Controllers\Controller;
use App\Models\MaxBotMessage;
use App\Models\MaxBotUser;
use BushlanovDev\MaxMessengerBot\Api;
use BushlanovDev\MaxMessengerBot\Enums\MessageFormat;
use BushlanovDev\MaxMessengerBot\Laravel\MaxBotManager;
use Illuminate\Http\Request;

class MaxBotSendMessageController extends Controller
{
    public function __invoke(MaxBotUser $maxBotUser, string $message)
    {
        $api = new Api(env('MAXBOT_ACCESS_TOKEN'));

        $api->sendMessage(
            $maxBotUser->max_user_id,
            null,
            $message,
            null,
            MessageFormat::Markdown
        );

        MaxBotMessage::query()
            ->create(
                [
                    'max_user_id' => $maxBotUser->max_user_id,
                    'max_chat_id' => null,
                    'timestamp' => now(),
                    'message' => 'SEND - ' . $message,
                ]
            );

    }
}
