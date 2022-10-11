<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Admin;
use App\Policies\SchoolPolicy;
use App\Models\User;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Gate;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        User::class => SchoolPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
       
        $this->registerPolicies();

        Auth::provider('mycustomadmin', function ($app, array $config) {

            if ($admin = Session::get('customAdmin')) {
                return new CustomAdminProvider($admin);
            }

            return $app->make(EloquentUserProvider::class, ['model' => $config['model']]);
        });

        Gate::define('admin', function (Admin $user) {
            return $user->hasRole('admin');
        });

        Gate::define('super-admin', function (Admin $user) {
            return $user->hasRole('super-admin');
        });

        Gate::define('content_manager', function (Admin $user) {
            return $user->hasRole('content_manager');
        });

        Gate::define('news_feed', function (Admin $user) {
            return $user->hasRole('news_feed');
        });

        Gate::define('yearbook.publish', function (Admin $user) {
            return $user->hasRole(['admin','super-admin']);
        });


    }
}
