<?php
namespace App\Repositories\Product;

use App\Repositories\RepositoryInterface;

interface ProductRepositoryInterface extends RepositoryInterface
{
    public function getAllProductBySearch($request);
    public function getRelativeProductsData(
        $type_id, 
        $producer_id, 
        $id
    );
}
