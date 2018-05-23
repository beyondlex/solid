<?php

namespace App\Providers;

use Api\Admin\Extensions\JwtGuard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::extend('jwt-guard', function ($app, $name, array $config) {
            return new JwtGuard();
        });

        //
        Passport::routes();
        Passport::tokensCan([
        	'user-profile'=>'Get user profile.',
			'department-manage'=>'Manage department.'
		]);
        Passport::enableImplicitGrant();


    }
}
