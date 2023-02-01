<?php

namespace App\Http\Services;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Http;

final class OpenWeatherService
{
    protected const WEATHER_FORECAST_ENDPOINT = 'https://api.openweathermap.org/data/2.5/weather?q=%s&appid=%s';

    /**
     * @param $params
     * @return array|mixed|string
     */
    public function findByCity(string $city): JsonResource
    {
        $apiKey = \config('services.openWeather.apiKey');
        $url = \sprintf(self::WEATHER_FORECAST_ENDPOINT, $city, $apiKey);

        try {
            return (Http::get($url))->json();
        } catch (\Exception $e) {
            return \sprintf('[ERROR] OpenWeather request failed: %s', $e->getMessage());
        }
    }
}

