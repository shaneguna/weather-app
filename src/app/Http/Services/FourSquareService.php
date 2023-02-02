<?php

namespace App\Http\Services;

use App\Http\Requests\FourSquareSearchRequest;
use App\Http\Services\Interfaces\FourSquareServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

final class FourSquareService implements FourSquareServiceInterface
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
            $request = (Http::withHeaders($headers))
                ->get($url)
                ->json();

            return response()->json($request);
        } catch (\Exception $e) {
            return response()->json(\sprintf('[ERROR] FourSquare request failed: %s', $e->getMessage()));
        }
    }
}

