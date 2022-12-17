<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TypeService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class   ApiTypeController extends Controller
{

    protected TypeService $typeService;

    public function __construct(TypeService $typeService)
    {
        $this->typeService = $typeService;
    }

    public function getAllType(): JsonResponse
    {
        $types = $this->typeService->getAll();
        return response()->json([
            'data' => $types,
        ], Response::HTTP_OK);
    }
}
