<?php

namespace App\Http\Controllers\MaxBot;

use App\Http\Controllers\Controller;
use App\Models\MaxBotMessage;
use BushlanovDev\MaxMessengerBot\Api;
use BushlanovDev\MaxMessengerBot\Enums\MessageFormat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MaxBotMessageController extends Controller
{
    public function store($request)
    {

        MaxBotMessage::query()
            ->create(
                [
                    'max_user_id' => $request['message']['sender']['user_id'],
                    'max_chat_id' => $request['message']['recipient']['chat_id'] ?? null,
                    'timestamp' => Carbon::createFromTimestampMs($request['timestamp'])->setTimezone('Asia/Yekaterinburg')->format('Y-m-d H:i:s'),
                    'message' => $request['message']['body']['text']
                ]
            );

        $api = new Api(env('MAXBOT_ACCESS_TOKEN'));

        $api->sendMessage(
            env('MAXBOT_ADMIN_USER'),
            null,
            'В чат бота отправили сообщение (id:'.
            $request['message']['sender']['user_id'].') ' .
            $request['message']['sender']['first_name'].' ' .
            $request['message']['sender']['last_name'].': ' .
            $request['message']['body']['text'],
            null,
            MessageFormat::Markdown
        );

        Log::info('store message');
    }
}
