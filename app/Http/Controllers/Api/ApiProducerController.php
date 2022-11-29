<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ProducerService;
use Illuminate\Http\Response;

class ApiProducerController extends Controller 
{

    protected $producerService;

    public function __construct(ProducerService $producerService) 
    {
        $this->producerService = $producerService;
    }

    public function getAllProducer() 
    {
        $types = $this->producerService->getAll();
        return response()->json([
            'data' => $types,
        ], Response::HTTP_OK);
    }
}