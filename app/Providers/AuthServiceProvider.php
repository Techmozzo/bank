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

        Gate::define('admin', function ($auditor){
            return $auditor->hasRole('admin');
        });

        Gate::define('auditor', function ($auditor){
            return ($auditor->hasRole('user') && $auditor->verified == 1 ) ? true : false;
        });

        Gate::define('isBlocked', function ($auditor){
            return !$auditor->is_blocked ? true : false;
        });

        Gate::define('is_company_verified', function($auditor){
            return $auditor->company->is_verified ? true : false;
        });

    }
}
