<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('admin', function ($banker) {
            return $banker->hasRole('admin');
        });

        Gate::define('banker', function ($banker) {
            return ($banker->hasRole('user') && $banker->verified == 1) ? true : false;
        });

        Gate::define('isBlocked', function ($banker) {
            return !$banker->is_blocked ? true : false;
        });

        Gate::define('is_bank_verified', function ($banker) {
            return $banker->bank->is_verified ? true : false;
        });
    }
}
