<?php

namespace App\Http\Services;

use App\Http\Requests\OpenWeatherSearchRequest;
use App\Http\Services\Interfaces\OpenWeatherServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

final class OpenWeatherService implements OpenWeatherServiceInterface
{
    protected const WEATHER_FORECAST_ENDPOINT = 'https://api.openweathermap.org/data/2.5/weather?q=%s&appid=%s&units=metric';

    /**
     * @param OpenWeatherSearchRequest $request
     * @return JsonResponse
     */
    public function findByCity(OpenWeatherSearchRequest $request): JsonResponse
    {
        $apiKey = \config('services.openWeather.apiKey');
        $url = \sprintf(self::WEATHER_FORECAST_ENDPOINT, $request->getCity(), $apiKey);

        try {
            $request = (Http::get($url))
                ->json();

            return response()->json($request);
        } catch (\Exception $e) {
            return response()->json(\sprintf('[ERROR] OpenWeather request failed: %s', $e->getMessage()));
        }
    }
}

