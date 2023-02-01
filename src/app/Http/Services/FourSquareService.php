<?php

namespace App\Http\Services;

use App\Http\Requests\FourSquareSearchRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

final class FourSquareService
{
    protected const WEATHER_FORECAST_ENDPOINT = 'https://api.foursquare.com/v3/places/search?near=%s&limit=%s';

    /**
     * @param FourSquareSearchRequest $request
     * @return JsonResponse
     */
    public function search(FourSquareSearchRequest $request): JsonResponse
    {
        $apiKey = \config('services.fourSquare.apiKey');
        $headers = [
            'Authorization' => $apiKey,
            'accept' => 'application/json',
        ];
        $url = \sprintf(self::WEATHER_FORECAST_ENDPOINT, $request->getCity(), $request->getLimit());

        try {
            return (Http::withHeaders($headers))
                ->get($url)
                ->json();
        } catch (\Exception $e) {
            return response()->json(\sprintf('[ERROR] OpenWeather request failed: %s', $e->getMessage()));
        }
    }
}

