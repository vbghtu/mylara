<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

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
        //  @todo это тест сюда надо будет прокинуть меню инабор его поле чуть позже
        Inertia::share([
            'layoutData' => function () {
                return [
                    'currentDate' => now()->format('d.m.Y'),
                    'appName' => config('app.name'),
                    // Другие общие данные
                ];
            },
            // Laravel Breeze/Jetstream уже делает так с 'auth' и 'errors'
        ]);
    }
}
