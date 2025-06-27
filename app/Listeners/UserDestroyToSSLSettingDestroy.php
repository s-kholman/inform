<?php

namespace App\Listeners;

use App\Events\UserDestroyEvent;
use App\Http\Controllers\Cabinet\VPN\Ikev2\SettingsDestroy;
use App\Http\Controllers\Cabinet\VPN\Ikev2\SslRevoke;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserDestroyToSSLSettingDestroy
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserDestroyEvent $event): void
    {
        $sslRevoke = new SslRevoke($event->user);
        $sslRevoke->render();

        $settingsDestroy = new SettingsDestroy($event->user);
        $settingsDestroy->render();
    }
}
