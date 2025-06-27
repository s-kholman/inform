<?php

namespace App\Listeners;

use App\Events\UserDestroyEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserDestroyToRegistrationDestroy
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
        $event->user->Registration->delete();
    }
}
