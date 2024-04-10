<?php

namespace App\Providers;

use App\Models\Pole;
use App\Models\Registration;
use App\Models\User;
use App\Observers\UserObserver;
use App\Policies\PolePolicy;
use App\Policies\RegistrationPolicy;
use Illuminate\Pagination\Paginator;
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
        URL::forceScheme('https');
        User::observe(UserObserver::class);
        Paginator::useBootstrap();
    }
}
