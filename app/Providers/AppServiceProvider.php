<?php

namespace App\Providers;

use App\Events\ApplicationEvent;
use App\Events\UserDestroyEvent;
use App\Http\Controllers\Application\ApplicationRun;
use App\Listeners\ApplicationRunListener;
use App\Listeners\UserDestroyToRegistrationDestroy;
use App\Listeners\UserDestroyToSSLSettingDestroy;
use App\Listeners\UserDestroyToVpnInfoDestroy;
use App\Models\Pole;
use App\Models\Registration;
use App\Models\User;
use App\Observers\UserObserver;
use App\Policies\PolePolicy;
use App\Policies\RegistrationPolicy;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(UserDestroyEvent::class,UserDestroyToVpnInfoDestroy::class);
        Event::listen(UserDestroyEvent::class,UserDestroyToRegistrationDestroy::class);
        Event::listen(UserDestroyEvent::class,UserDestroyToSSLSettingDestroy::class);
        Event::listen(ApplicationEvent::class, ApplicationRunListener::class);

        URL::forceScheme('https');
        User::observe(UserObserver::class);
        Paginator::useBootstrap();
    }
}
