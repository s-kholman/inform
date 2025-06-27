<?php

namespace App\Listeners;

use App\Events\UserDestroyEvent;
use App\Models\VpnInfo;

class UserDestroyToVpnInfoDestroy
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
        VpnInfo::query()
            ->where('registration_id', $event->user->Registration->id)
            ->delete();
    }
}
