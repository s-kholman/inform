<?php

namespace App\Providers;

use App\Models\SowingControlPotato;
use App\Policies\SowingControlPotatoPolicy;
use Illuminate\Support\Facades\Gate;
use App\Models\Pole;
use App\Models\Registration;
use App\Models\Sowing;
use App\Policies\PolePolicy;
use App\Policies\RegistrationPolicy;
use App\Policies\SowingPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Sowing::class => SowingPolicy::class,
        Registration::class => RegistrationPolicy::class,
        Pole::class => PolePolicy::class,
        SowingControlPotato::class => SowingControlPotatoPolicy::class,

    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
