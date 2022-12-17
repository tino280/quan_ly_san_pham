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

    public function getProducersByTypeId($type_id)
    {
        $producers = $this->model->where('type_id', $type_id)->get();
        return $producers;
    }
}
