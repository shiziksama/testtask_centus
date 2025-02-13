<?php

return [
    'default_provider' => \App\Services\Weather\OpenWeatherProvider::class,
    'providers' => [
        'openweather' => [
            'api_key' => env('OPENWEATHER_API_KEY'),
        ],
    ],
];
