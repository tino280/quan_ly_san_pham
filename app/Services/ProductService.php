<?php

namespace App\Services;

use App\Exceptions\MyException;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Slide\SlideRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
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
            throw new MyException('Không tìm thấy sản phẩm.');
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

    public function updateProduct(
        $product_id,
        $arr_update_product = [],
        $arr_slide = []
    )
    {
        $result = [];
        $product = $this->productRepo->find($product_id);
        if (!$product) {
            throw new ModelNotFoundException('Sản phẩm không tồn tại', 401);
        }
        DB::beginTransaction();
        try {
            if (isset($arr_update_product['image_link'])) {
                $path = $arr_update_product['image_link'];
                $image_name = $path->hashName();
                $arr_update_product['image_link'] = $image_name;
                $path->move(public_path("image/description/$product_id"), $image_name);
            }
            $result["updated_product"] = $this->productRepo->update($product_id, $arr_update_product);

            for ($i=1; $i<=4; $i++) {
                $slide = $this->slideRepo->getSlideByProductIdAndSlot($product_id, $i);
                // tạo cập nhập slide
                if (isset($arr_slide["slide$i"])) {
                    $path = $arr_slide["slide$i"];
                    $image_name = $path->hashName();
                    $path->move(public_path("image/slide/$product_id"), $image_name);
                    $data = [
                        "slot" => $i,
                        "image" => $image_name,
                        "product_id" => $product_id,
                    ];
                    if (!$slide) {
                        $result["slide$i"] = $this->slideRepo->save($data);
                    } else {
                        // File::delete(public_path("image/slide/$product_id/$slide->image"));
                        $this->slideRepo->update($slide->id, $data);
                        $result["slide$i"] = $this->slideRepo->find($slide->id);
                    }
                }
                //xóa slide
                if (isset($arr_slide["deleteSlide$i"])) {
                    //nếu có slide thì xóa
                    if ($slide) {
                        $this->slideRepo->delete($slide->id);
                    } else {
                        throw new ModelNotFoundException("Slide không tồn tại", 501);
                    }
                }
            }
            DB::commit();
            return $result;
        } catch(ModelNotFoundException $exception) {
            DB::rollBack();
            throw new ModelNotFoundException($exception->getMessage());
        }
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
