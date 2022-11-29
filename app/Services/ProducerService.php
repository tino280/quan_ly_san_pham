<?php

namespace App\Services;

use App\Repositories\Producer\ProducerRepositoryInterface;

class ProducerService 
{
    protected $producerRepo;

    public function __construct(ProducerRepositoryInterface $producerRepo) 
    {
        $this->producerRepo = $producerRepo;
    }

    public function getAll() 
    {
        $result = $this->producerRepo->getAll();
        return $result;
    }
}