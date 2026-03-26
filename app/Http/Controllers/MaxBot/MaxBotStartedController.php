<?php

namespace App\Http\Controllers\MaxBot;

use App\Http\Controllers\Controller;
use App\Models\MaxBotUser;
use Illuminate\Http\Request;

class MaxBotStartedController extends Controller
{
    public function __invoke($WebHook)
    {
        $maxUser = $WebHook->post('user');
        if (is_array($maxUser) && array_key_exists('user_id', $maxUser) && array_key_exists('first_name', $maxUser)) {
            $maxBotUser = MaxBotUser::query()
                ->updateOrCreate(
                    [
                        'max_user_id' => $maxUser['user_id'],
                    ],
                    [
                        'first_name' => $maxUser['first_name'],
                    ]
                );
            $identificationUser = new MaxBotIdentificationUserController();
            $identificationUser($maxBotUser);
        }
    }
}
