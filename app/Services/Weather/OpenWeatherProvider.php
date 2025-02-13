<?php

namespace App\Services\Weather;

use Illuminate\Support\Facades\Http;
use Cmfcmf\OpenWeatherMap;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;
use Http\Factory\Guzzle\RequestFactory;

class OpenWeatherProvider implements WeatherProvider
{
    protected string $apiKey;

    public function __construct()
    {
        $this->apiKey = config('weather.providers.openweather.api_key');
    }

    public function getWeatherByLocation($location): array
    {
        $httpRequestFactory = new RequestFactory();
        $httpClient = GuzzleAdapter::createWithConfig([]);
        $owm = new OpenWeatherMap($this->apiKey, $httpClient, $httpRequestFactory);
        $weather = $owm->getWeather($location, 'metric', 'en');

        $data = json_decode($weather->raw, true);
        var_dump($data);

        return [
            'pop' => $data['pop'] ?? null,
            'uv_index' => $data['uvi'] ?? null,
            'city' => $data['name'] ?? $location
        ];
    }

}
