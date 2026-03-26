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
    public function __invoke(string $phone, $message)
    {
        $vPhone = new PhonePrepare();
        $validate = $vPhone($phone);

        if ($validate['status']){
            $registration = Registration::query()
                ->where('phone', $validate['phone'])
                ->where('activation', true)
                ->first()
            ;
//empty($message['body']['attachments'][0]['payload']['vcf_info']
            if (!empty($registration)){
                $maxUser = MaxBotUser::query()
                    ->where('max_user_id', $message['body']['attachments'][0]['payload']['max_info']['user_id'])
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
                    'В чат бота отправили контакт id '.
                    $message['body']['attachments'][0]['payload']['max_info']['user_id']. ' '.
                    $message['body']['attachments'][0]['payload']['max_info']['first_name']. ' '.
                    $message['body']['attachments'][0]['payload']['max_info']['last_name']. ' '.
                    ', телефон ' . $validate['phone'],
                    null,
                    MessageFormat::Markdown
                );
            }
        }
    }
}
