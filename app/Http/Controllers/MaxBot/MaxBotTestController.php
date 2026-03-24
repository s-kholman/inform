<?php

namespace App\Http\Controllers\MaxBot;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\User;
use BushlanovDev\MaxMessengerBot\Api;
use BushlanovDev\MaxMessengerBot\Models\Attachments\Buttons\Inline\CallbackButton;
use BushlanovDev\MaxMessengerBot\Models\Attachments\Requests\InlineKeyboardAttachmentRequest;
use BushlanovDev\MaxMessengerBot\Models\BotPatch;

class MaxBotTestController extends Controller
{
    public function index()
    {
        $maxBotSendMessage = new MaxBotSendMessageController();

        $users = User::with(['roles', 'Registration.MaxBotUser'])->get()
            ->filter(fn($user) => $user->roles->where('name', '=', 'DeviceWarningTemperatureStorage-HRAN.user')->toArray()
            );

        //dump($users);

        foreach ($users as $user) {

            if (!empty($user->Registration->MaxBotUser->max_user_id)){

                //dump($user->Registration->MaxBotUser->max_user_id);
                $maxBotSendMessage($user->Registration->MaxBotUser, 'Температура бла бля');

              //  dump($user->Registration->MaxBotUser->max_user_id);

            }


        }

        $u = Registration::query()
            ->with(['MaxBotUser'])
            ->where('id', 1)
            ->first();

        dd($u);

    }

}
