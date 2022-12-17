<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ProducerService;
use Illuminate\Http\Response;
use Throwable;

class ApiProducerController extends Controller
{

    protected $producerService;

    public function __construct(ProducerService $producerService)
    {
        $this->producerService = $producerService;
    }

    public function getAllProducer()
    {
        $producer = $this->producerService->getAll();
        return response()->json([
            'data' => $producer,
        ], Response::HTTP_OK);
    }

    public function getProducersByTypeId($type_id)
    {
        $producer = $this->producerService->getProducersByTypeId($type_id);
        return response()->json([
            'data' => $producer,
        ], Response::HTTP_OK);
    }
}
