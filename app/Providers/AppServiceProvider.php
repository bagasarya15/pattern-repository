<?php

namespace App\Providers;

use App\Exceptions\Handler;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Debug\ExceptionHandler;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(ExceptionHandler::class, Handler::class);

        $this->app->bind(
            'App\Interfaces\Auth\AuthInterface',
            'App\Repositories\Auth\AuthRepository'
        );
    }

    public function boot()
    {

    }
}
