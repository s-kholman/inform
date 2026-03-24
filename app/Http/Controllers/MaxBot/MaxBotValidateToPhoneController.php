<?php

namespace App\Http\Controllers\MaxBot;

use App\Actions\PhonePrepare\PhonePrepare;
use App\Http\Controllers\Controller;
use App\Models\MaxBotUser;
use App\Models\Registration;
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
                Log::info('оповещаем администратора о регистрации в MAX, от пользователя просим ФИО');
            }
        }
    }
}
