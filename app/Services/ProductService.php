<?php

namespace App\Services;

use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Slide\SlideRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;

class ProductService 
{
    protected $productRepo;
    protected $slideRepo;

    public function __construct(
        ProductRepositoryInterface $productRepo,
        SlideRepositoryInterface $slideRepo
    ) {
        $this->productRepo = $productRepo;
        $this->slideRepo = $slideRepo;
    }

    public function getAll() 
    {
        $result = $this->productRepo->getAll();
        return $result;
    }

    public function getAllBySearch($arr) 
    {
        $products = $this->productRepo->getAllProductBySearch($arr);
        if (!$products->total() || $products->currentPage() > $products->lastPage()) {
            throw new ModelNotFoundException('Không tìm thấy sản phẩm.');
        }
        $result = [
            'pagination' => [
                'total' => $products->total(),
                'per_page' => $products->perPage(),
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'from' => $products->firstItem(),
                'to' => $products->lastItem(),
            ],
            'data' => $products,
        ];
        return $result;
    }

    public function saveProductData($arr = []) 
    {
        $path = $arr['image_link'];
        $image_name = $path->hashName();
        $arr['image_link'] = $image_name;
        $result = $this->productRepo->save($arr);
        $path->move(public_path("image/description/$result->id"), $image_name);
        return $result;
    }

    public function updateProduct($id, $arr = []) 
    {
        $product = $this->productRepo->find($id);
        if (!$product) {
            throw new ModelNotFoundException('Không có sản phẩm');
        }
        if (isset($arr['image_link'])) {
            File::deleteDirectory(public_path("image/description/$id"));
            $path = $arr['image_link'];
            $image_name = $path->hashName();
            $arr['image_link'] = $image_name;
            $path->move(public_path("image/description/$id"), $image_name);
        }
        $this->productRepo->update($id, $arr);
    }

    public function delete($id) 
    {
        $product = $this->productRepo->find($id);
        if (!$product) {
            throw new ModelNotFoundException('Không có sản phẩm');
        }
        File::deleteDirectory(public_path("image/description/$id"));
        $this->productRepo->delete($id);
    }

    public function getById($id) 
    {
        $product = $this->productRepo->find($id);
        if (!$product) {
            throw new ModelNotFoundException('Không có sản phẩm.');
        }      
        return $product;
    }

    public function getRelativeProducts($type_id, $producer_id, $id) 
    {
        $products = $this->productRepo->getRelativeProductsData($type_id, $producer_id, $id);
        return $products;
    }
}