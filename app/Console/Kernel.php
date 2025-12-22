<?php

namespace App\Console;

use App\Actions\Printer\PrinterRunSchedule;
use App\Actions\TemperatureGetMQTTSchedule\TemperatureGetMQTTSchedule;
use App\Http\Controllers\Cabinet\VPN\Schedule\ExpirationSSL;
use App\Http\Controllers\Cabinet\VPN\Schedule\RemoveSettings;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        //Опрос принтеров каждый час
        $schedule->call(new PrinterRunSchedule())->hourly();
        //Опрос по MQTT каждые 15 минут
        //$schedule->call(new TemperatureGetMQTTSchedule())->everyFifteenMinutes();
        //Проверка сертификата пользователя и отправка Email за 30-15-3 дня до окончания
        //В 12 дня.
        $schedule->call(new ExpirationSSL())->dailyAt('12:00')->timezone('Asia/Yekaterinburg');
        //Удаление не используемых настроек, когда истекает срок действия SSL
        $schedule->call(new RemoveSettings())->daily()->timezone('Asia/Yekaterinburg');

    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
