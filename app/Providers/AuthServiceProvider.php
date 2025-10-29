<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerPolicies();

        // Gate для админа
        Gate::define('admin', function ($user) {
            return $user->isAdmin();
        });

        // Gate для модератора
        Gate::define('moderate', function ($user) {
            return $user->canModerate();
        });

        // Gate для продавца
        Gate::define('sell', function ($user) {
            return $user->isSeller();
        });

        // Gate для управления товарами
        Gate::define('manage-products', function ($user) {
            return $user->canManageProducts();
        });

        // Gate для зарегистрированных пользователей
        Gate::define('user', function ($user) {
            return !$user->isGuest();
        });
    }
}
