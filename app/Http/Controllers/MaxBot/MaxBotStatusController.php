<?php

namespace App\Http\Controllers\MaxBot;

use App\Http\Controllers\Controller;
use App\Models\MaxBotUser;
use BushlanovDev\MaxMessengerBot\Api;
use BushlanovDev\MaxMessengerBot\Enums\MessageFormat;

class MaxBotStatusController extends Controller
{
    public function __invoke($WebHook, bool $status_bot)
    {
        $maxUser = $WebHook->post('user');

        if (is_array($maxUser) && array_key_exists('user_id', $maxUser) && array_key_exists('first_name', $maxUser)) {
            $api = new Api(env('MAXBOT_ACCESS_TOKEN'));
            $maxBotUser = MaxBotUser::query()
                ->updateOrCreate(
                    [
                        'max_user_id' => $maxUser['user_id'],
                    ],
                    [
                        'first_name' => $maxUser['first_name'],
                        'last_name' => $maxUser['last_name'],
                        'status_bot' => $status_bot,
                    ]
                );

            if ($status_bot){

                $api->sendMessage(
                    env('MAXBOT_ADMIN_USER'),
                    null,
                    'Пользователь (id:'.
                    $maxUser['user_id'].') ' .
                    $maxUser['first_name'].' ' .
                    $maxUser['last_name'].': ' .
                    ' Запустил бота',
                    null,
                    MessageFormat::Markdown
                );

                $identificationUser = new MaxBotIdentificationUserController();
                $identificationUser($maxBotUser);
            } else {


                $api->sendMessage(
                    env('MAXBOT_ADMIN_USER'),
                    null,
                    'Пользователь (id:'.
                    $maxUser['user_id'].') ' .
                    $maxUser['first_name'].' ' .
                    $maxUser['last_name'].': ' .
                    ' Остановил бота',
                    null,
                    MessageFormat::Markdown
                );
            }
        }
    }
}
