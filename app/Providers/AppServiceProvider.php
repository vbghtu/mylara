<?php

namespace App\Providers;

use App\Models\Review;
use App\Observers\ReviewObserver;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

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
        Relation::morphMap([
            'product' => \App\Models\Product::class,
            'showcase' => \App\Models\Showcase::class,
            // 'comment' => \App\Models\Comment::class,
        ]);

        Review::observe(ReviewObserver::class);


        //  @todo это тест сюда надо будет прокинуть меню и набор его поле чуть позже

    }
}
