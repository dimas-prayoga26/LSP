<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Auth\Access\Response;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('admin', function ($user) {
            return $user->role === 'Admin'
                ? Response::allow()
                : Response::deny('Unauthorized', 403);
        });

        Gate::define('asesor', function ($user) {
            return $user->role === 'Asesor'
                ? Response::allow()
                : Response::deny('Unauthorized', 403);
        });

        Gate::define('asesi',function($user) {
            return $user->role === 'Asesi'
            ? Response::allow()
            : Response::deny('Unauthorized', 403);
        });

        Gate::define('canAny', function ($user, ...$roles) {
            foreach ($roles as $permission) {
                if (Gate::allows($permission)) {
                    return Response::allow();
                }
            }
        });
    }
}
