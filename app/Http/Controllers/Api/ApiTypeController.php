<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TypeService;
use Illuminate\Http\Response;

class ApiTypeController extends Controller 
{

    protected $typeService;

    public function __construct(TypeService $typeService) 
    {
        $this->typeService = $typeService;
    }

    public function getAllType() 
    {
        $types = $this->typeService->getAll();
        return response()->json([
            'data' => $types,
        ], Response::HTTP_OK);
    }
}