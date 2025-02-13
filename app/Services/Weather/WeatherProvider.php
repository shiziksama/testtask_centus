<?php

namespace App\Services\Weather;

interface WeatherProvider
{
    public function getWeatherByLocation($location): ?array;
    
}
