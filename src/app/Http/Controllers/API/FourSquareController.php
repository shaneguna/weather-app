<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\FourSquareSearchRequest;
use App\Http\Services\FourSquareService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FourSquareController
{
    private FourSquareService $fourSquareService;

    public function __construct(FourSquareService $fourSquareService)
    {
        $this->fourSquareService = $fourSquareService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $searchDto = (new FourSquareSearchRequest())
            ->setCity($request->get('city'))
            ->setLimit($request->get('limit'));

        return $this->fourSquareService->search($searchDto);
    }
}
