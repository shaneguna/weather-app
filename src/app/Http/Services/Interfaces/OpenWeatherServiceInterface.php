<?php

namespace App\Http\Services\Interfaces;

use App\Http\Requests\OpenWeatherSearchRequest;
use Illuminate\Http\JsonResponse;

interface OpenWeatherServiceInterface
{
    public function findByCity(OpenWeatherSearchRequest $request): JsonResponse;
}
