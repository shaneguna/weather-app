<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\OpenWeatherSearchRequest;
use App\Http\Services\Interfaces\OpenWeatherServiceInterface;
use App\Http\Services\OpenWeatherService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

final class OpenWeatherController
{
    private OpenWeatherServiceInterface $openWeatherService;

    public function __construct(OpenWeatherService $openWeatherService)
    {
        $this->openWeatherService = $openWeatherService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $searchDto = (new OpenWeatherSearchRequest())
                ->setCity($request->get('city'));

            return $this->openWeatherService->findByCity($searchDto);
        } catch (\Throwable $e) {
            return response()->json(\sprintf('[ERROR] %s', $e->getMessage()), HttpResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
