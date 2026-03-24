<?php

namespace App\Http\Controllers\MaxBot;

use App\Actions\Acronym\AcronymFullNameUser;
use App\Http\Controllers\Controller;
use App\Models\MaxBotUser;
use App\Models\Registration;
use Illuminate\Http\Request;

class MaxBotIdentificationUserController extends Controller
{


    public function __invoke(MaxBotUser $maxBotUser)
    {
        $maxBotSendMessageController = new MaxBotSendMessageController();

        if (empty($maxBotUser->registration_id)){
            $requestContact = new MaxBotRequestContactController();
            $requestContact($maxBotUser);
        } else {
            $registration = Registration::query()
                ->where('id', $maxBotUser->registration_id)
                ->first();

            $acronym = new AcronymFullNameUser();

            $maxBotSendMessageController($maxBotUser, 'Здравствуйте '.$acronym->Acronym($registration).'. Бот будет оповещать вас, согласно назначенных вам прав');
        }
    }
}
