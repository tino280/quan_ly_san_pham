<?php

namespace App\Repositories\Type;

use App\Models\Type;
use App\Repositories\BaseRepository;
use App\Repositories\Type\TypeRepositoryInterface;

class TypeRepository extends BaseRepository implements TypeRepositoryInterface
{
    public function getModel() 
    {
        return Type::class;
    }
}