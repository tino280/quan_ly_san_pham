<?php
namespace App\Repositories\Producer;

use App\Repositories\RepositoryInterface;

interface ProducerRepositoryInterface extends RepositoryInterface
{
    public function getProducersByTypeId($type_id);
}
