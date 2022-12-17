<?php

namespace App\Services;

use App\Repositories\Type\TypeRepositoryInterface;

class TypeService
{
    protected $typeRepo;

    public function __construct(TypeRepositoryInterface $typeRepo)
    {
        $this->typeRepo = $typeRepo;
    }

    public function getAll()
    {
        $result = $this->typeRepo->getAll();
        return $result;
    }
}
