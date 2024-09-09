<?php

namespace App\Providers;

use App\Models\StockMovement;
use App\Observers\StockObserver;
use Illuminate\Pagination\Paginator;
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
        StockMovement::observe(StockObserver::class);

        Paginator::useBootstrapFour();
    }
}
