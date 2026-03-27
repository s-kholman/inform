<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MaxBot\MaxBotSendMessageController;
use App\Http\Controllers\SMS\Send\SmsSend;
use App\Models\DeviceWarningTemperatureStorage;
use App\Models\ProductMonitoringDevice;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use PDOException;

class DeviceWarningTemperatureStorageParserController extends Controller
{
    public function __invoke(ProductMonitoringDevice $productMonitoringDevice)
    {
        try {
            $parser = DeviceWarningTemperatureStorage::query()
                ->with(['storageName', 'role'])
                ->where('storage_name_id', '=', $productMonitoringDevice->storage_name_id)
                ->where('active', '=', true)
                ->where(function (Builder $query) use ($productMonitoringDevice) {
                    $query
                        ->where('temperature_min', '>', $productMonitoringDevice->temperature_point_one ?? 0)
                        ->orWhere('temperature_min', '>', $productMonitoringDevice->temperature_point_two ?? 0)
                        ->orWhere('temperature_min', '>', $productMonitoringDevice->temperature_humidity ?? 0)
                        ->orWhere('temperature_max', '<', $productMonitoringDevice->temperature_point_one ?? 0);
                })
                ->first();
        } catch (PDOException $exception) {
            Log::warning('DeviceWarningTemperatureStorage - запрос ' . $exception);
        }


        if (!empty($parser)) {

            $users = User::with(['roles', 'Registration.MaxBotUser'])
                ->get()
                ->filter(fn($user) => $user->roles->where('name', '=', $parser->role->name)
                    ->toArray())
            ;

            if ($users->isNotEmpty()) {
                $sms = new SmsSend();
                $maxBotSendMessage = new MaxBotSendMessageController();

                $message = $parser->storageName->name;

                if (!empty($productMonitoringDevice->temperature_point_one) && $parser->temperature_min > $productMonitoringDevice->temperature_point_one) {
                    $message .= " бурт t " . round($productMonitoringDevice->temperature_point_one, 1) . "  ниже нормы";
                } elseif (!empty($productMonitoringDevice->temperature_point_one) && $parser->temperature_max < $productMonitoringDevice->temperature_point_one) {
                    $message .= " бурт t " . round($productMonitoringDevice->temperature_point_one, 1) . ", это выше нормы";
                }

                if (!empty($productMonitoringDevice->temperature_point_two) && $parser->temperature_min > $productMonitoringDevice->temperature_point_two) {
                    $message .= " шахта t " . round($productMonitoringDevice->temperature_point_two, 1) . " ниже нормы";
                }
                if (!empty($productMonitoringDevice->temperature_humidity) && $parser->temperature_min > $productMonitoringDevice->temperature_humidity) {
                    $message .= " устр. t " . round($productMonitoringDevice->temperature_humidity, 1 . " ниже нормы");
                }

                foreach ($users as $user) {

                    if (!empty($user->Registration->MaxBotUser->max_user_id) && $user->Registration->MaxBotUser->status_bot){
                        try {
                            $maxBotSendMessage($user->Registration->MaxBotUser, $message);
                        }catch (\Throwable $exception){
                            Log::warning('Error send message MAX: ' . $exception);
                            $sms->send($user->Registration->phone, $message);
                        }

                    } else {

                        $sms->send($user->Registration->phone, $message);

                    }

                }

            }

        }

    }

}
