<?php
namespace App\Repositories\Producer;

use App\Models\Producer;
use App\Repositories\BaseRepository;

class ProducerRepository extends BaseRepository implements ProducerRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return Producer::class;
    }

}