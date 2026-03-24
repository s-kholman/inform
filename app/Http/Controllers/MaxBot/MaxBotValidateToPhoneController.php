<?php

namespace App\Http\Controllers\MaxBot;

use App\Actions\PhonePrepare\PhonePrepare;
use App\Http\Controllers\Controller;
use App\Models\MaxBotUser;
use App\Models\Registration;
use BushlanovDev\MaxMessengerBot\Api;
use BushlanovDev\MaxMessengerBot\Enums\MessageFormat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MaxBotValidateToPhoneController extends Controller
{
    public function __invoke(string $phone, string $userId)
    {
        $vPhone = new PhonePrepare();
        $validate = $vPhone($phone);

        if ($validate['status']){
            $registration = Registration::query()
                ->where('phone', $validate['phone'])
                ->first()
            ;

            if (!empty($registration)){
                $maxUser = MaxBotUser::query()
                    ->where('max_user_id', $userId)
                    ->first();

                if (!empty($maxUser)){
                    $maxUser->update(
                        [
                            'registration_id' => $registration->id
                        ]
                    );

                    $h = new MaxBotIdentificationUserController();
                    $h($maxUser);
                }

            } else {
                $api = new Api(env('MAXBOT_ACCESS_TOKEN'));

                $api->sendMessage(
                    env('MAXBOT_ADMIN_USER'),
                    null,
                    'В чат бота отправили контакт id '.$userId.', телефон ' . $validate['phone'],
                    null,
                    MessageFormat::Markdown
                );
            }
        }
    }
}
