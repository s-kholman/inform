<?php

namespace App\Listeners;

use App\Events\ApplicationEvent;
use App\Http\Controllers\Application\ApplicationRun;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ApplicationRunListener
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
    public function handle(ApplicationEvent $event): void
    {
        $r = new ApplicationRun();
        $r($event->application);
    }
}
