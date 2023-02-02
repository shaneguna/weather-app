<?php

namespace App\Providers;

use App\Http\Services\Interfaces\FourSquareServiceInterface;
use App\Http\Services\Interfaces\OpenWeatherServiceInterface;
use App\Http\Services\OpenWeatherService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton(OpenWeatherServiceInterface::class, OpenWeatherService::class);
        $this->app->singleton(FourSquareServiceInterface::class, FourSquareServiceInterface::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
