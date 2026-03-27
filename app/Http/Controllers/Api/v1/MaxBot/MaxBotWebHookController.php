<?php

namespace App\Http\Controllers\Api\v1\MaxBot;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MaxBot\MaxBotStatusController;
use App\Http\Controllers\MaxBot\MaxBotValidateToPhoneController;
use App\Http\Controllers\MaxBot\MaxBotMessageController;
use BushlanovDev\MaxMessengerBot\Laravel\MaxBotManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MaxBotWebHookController extends Controller
{

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __invoke(Request $request, MaxBotManager $botManager)
    {

        if ($request->header('X-Max-Bot-Api-Secret') != env('MAXBOT_WEBHOOK_SECRET')) {

            return response(['message' => 'unauthorized'])->setStatusCode(401);

        }

      //  Log::info(json_encode($request->post()));

        if (!empty($request->post('update_type')) && $request->post('update_type') == 'bot_started') {

            $maxBotUserController = new MaxBotStatusController();

            $maxBotUserController($request, true);

        }

        if (!empty($request->post('update_type')) && $request->post('update_type') == 'bot_stopped') {

            $maxBotUserController = new MaxBotStatusController();

            $maxBotUserController($request, false);

        }

        if (!empty($request->post('update_type')) && $request->post('update_type') == 'message_created') {

            $message = $request->post('message');

            if (!empty($message['body']['attachments'][0]['payload']['vcf_info'])) {

                $phone = substr($message['body']['attachments'][0]['payload']['vcf_info'], strpos($message['body']['attachments'][0]['payload']['vcf_info'], 'cell') + 5, 11);

                $validate = new MaxBotValidateToPhoneController();

                $validate($phone, $message);
            }

            if (!empty($message['body']['text'])) {

                $messageStore = new MaxBotMessageController();

                $messageStore->store($request);

            }
        }
    }
}
