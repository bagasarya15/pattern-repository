<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MasterServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            'App\Interfaces\Master\UserInterface',
            'App\Repositories\Master\UserRepository'
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
