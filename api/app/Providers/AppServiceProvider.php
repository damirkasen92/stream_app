<?php

namespace App\Providers;

use App\Factories\Mercure\MercureTokenFactory;
use App\Factories\Mercure\MercureTokenFactoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(MercureTokenFactoryInterface::class, function ($app) {
            return new MercureTokenFactory(config('mercure.jwt_secret'));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
