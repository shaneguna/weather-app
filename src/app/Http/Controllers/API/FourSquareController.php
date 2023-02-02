<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\FourSquareSearchRequest;
use App\Http\Services\FourSquareService;
use App\Http\Services\Interfaces\FourSquareServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

final class FourSquareController
{
    private FourSquareServiceInterface $fourSquareService;

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
        try {
            $searchDto = (new FourSquareSearchRequest())
                ->setCity($request->get('city'));

            if ($request->has('limit') === true) {
                $searchDto->setLimit($request->get('limit'));
            }

            return $this->fourSquareService->search($searchDto);
        } catch (\Throwable $e) {
            return response()->json(\sprintf('[ERROR] %s', $e->getMessage()), HttpResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
