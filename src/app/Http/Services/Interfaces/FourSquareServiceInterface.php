<?php

namespace App\Http\Services\Interfaces;

use App\Http\Requests\FourSquareSearchRequest;
use Illuminate\Http\JsonResponse;

interface FourSquareServiceInterface
{
    public function search(FourSquareSearchRequest $request): JsonResponse;
}
