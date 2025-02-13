<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Weather\WeatherService;
use App\Services\Weather\OpenWeatherProvider;
use App\Services\Weather\WeatherProvider;

class WeatherServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(WeatherService::class, function () {
            $providerClass = config('weather.default_provider');

            if (!class_exists($providerClass)) {
                throw new \Exception("Weather provider class {$providerClass} does not exist.");
            }

            $provider = app($providerClass);
            return new WeatherService($provider);
        });

        // Зареєструємо реалізацію інтерфейсу
        $this->app->bind(WeatherProvider::class, OpenWeatherProvider::class);
    }

    public function boot()
    {
        //
    }
}
