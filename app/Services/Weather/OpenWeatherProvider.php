<?php

namespace App\Services\Weather;

use Illuminate\Support\Facades\Http;
use Cmfcmf\OpenWeatherMap;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\HttpFactory;
use App\Models\CityCoords;

class OpenWeatherProvider implements WeatherProvider
{
    protected string $apiKey;
    protected GuzzleClient $httpClient;

    public function __construct()
    {
        $this->apiKey = config('weather.providers.openweather.api_key');
        $this->httpClient = new GuzzleClient();
    }

    public function getWeatherByLocation($location): array
    {
        $coordinates = $this->getCoordinates($location);
        return $this->fetchWeatherData($coordinates['lat'], $coordinates['lon']);
    }

    private function getCoordinates(string $location): array
    {
        $cityCoords = CityCoords::where('city_name', $location)->first();

        if ($cityCoords) {
            return ['lat' => $cityCoords->latitude, 'lon' => $cityCoords->longitude];
        }

        $geoData = $this->fetchGeoData($location);

        CityCoords::create([
            'city_name' => $location,
            'latitude' => $geoData['lat'],
            'longitude' => $geoData['lon'],
        ]);

        return $geoData;
    }

    private function fetchGeoData(string $location): array
    {
        $geoUrl = "http://api.openweathermap.org/geo/1.0/direct?q={$location}&limit=1&appid={$this->apiKey}";
        $geoResponse = $this->httpClient->request('GET', $geoUrl);
        $geoData = json_decode($geoResponse->getBody(), true);

        if (empty($geoData)) {
            throw new \Exception("Location not found");
        }

        return ['lat' => $geoData[0]['lat'], 'lon' => $geoData[0]['lon']];
    }

    private function fetchWeatherData(float $lat, float $lon): array
    {
        $weatherUrl = "https://api.openweathermap.org/data/3.0/onecall?lat={$lat}&lon={$lon}&exclude=daily,minutely&appid={$this->apiKey}";
        $weatherResponse = $this->httpClient->request('GET', $weatherUrl);
        $weatherData = json_decode($weatherResponse->getBody(), true)['hourly'][0];

        return [
            'pop' => $weatherData['pop'] ?? null,
            'uvi' => $weatherData['uvi'] ?? null,
        ];
    }
}
