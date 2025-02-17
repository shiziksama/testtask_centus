<?php

use App\Services\Weather\OpenWeatherProvider;
use App\Models\CityCoords;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

uses(TestCase::class)->in(__DIR__);

beforeEach(function () {
    Config::set('weather.providers.openweather.api_key', 'test_api_key');
    $this->weatherProvider = new OpenWeatherProvider();
});

test('getWeatherByLocation with existing coordinates', function () {
    $location = 'TestCity';
    CityCoords::create([
        'city_name' => $location,
        'latitude' => 10.0,
        'longitude' => 20.0,
    ]);

    Http::fake([
        'api.openweathermap.org/*' => Http::response(['hourly' => [['pop' => 0.5, 'uvi' => 3.0]]], 200)
    ]);

    $weather = $this->weatherProvider->getWeatherByLocation($location);

    expect((float)$weather['pop'])->toBe(0.5);
    expect((float)$weather['uvi'])->toBe(3.0);
});

test('getWeatherByLocation with new coordinates', function () {
    $location = 'NewCity';

    Http::fake([
        'api.openweathermap.org/geo/1.0/direct*' => Http::response([['lat' => 30.0, 'lon' => 40.0]], 200),
        'api.openweathermap.org/data/3.0/onecall*' => Http::response(['hourly' => [['pop' => 0.7, 'uvi' => 5.0]]], 200)
    ]);

    $weather = $this->weatherProvider->getWeatherByLocation($location);

    expect((float)$weather['pop'])->toBe(0.7);
    expect((float)$weather['uvi'])->toBe(5.0);

    $cityCoords = CityCoords::where('city_name', $location)->first();
    expect($cityCoords)->not->toBeNull();
    expect((float)$cityCoords->latitude)->toBe(30.0);
    expect((float)$cityCoords->longitude)->toBe(40.0);
});

test('getWeatherByLocation throws exception for invalid location', function () {
    $location = 'InvalidCity';

    Http::fake([
        'api.openweathermap.org/geo/1.0/direct*' => Http::response([], 200)
    ]);

    $this->expectException(\Exception::class);
    $this->expectExceptionMessage('Location not found');

    $this->weatherProvider->getWeatherByLocation($location);
});
