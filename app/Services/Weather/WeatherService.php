<?php

namespace App\Services\Weather;

class WeatherService
{
    protected WeatherProvider $provider;

    public function __construct(WeatherProvider $provider)
    {
        $this->provider = $provider;
    }

    public function getWeatherByLocation($location): array
    {
        return $this->provider->getWeatherByLocation($location);
    }

}
