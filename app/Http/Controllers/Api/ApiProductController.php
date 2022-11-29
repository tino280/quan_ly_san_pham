<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Services\ProductService;
use App\Services\SlideService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApiProductController extends Controller 
{

    protected $productService;
    protected $slideService;

    public function __construct(
        ProductService $productService, 
        SlideService $slideService
    ) {
        $this->productService = $productService;
        $this->slideService = $slideService;
    }

    public function getProductBySearch(Request $request) 
    {
        $arr = $request->all();
        try {
            $products = $this->productService->getAllBySearch($arr);
        } catch(ModelNotFoundException $exception) {
            return response()->json([
                "message" => $exception->getMessage(),
            ], Response::HTTP_NOT_FOUND);
        }
        return response()->json([
            "pagination" => $products["pagination"],
            "data" => $products["data"],
        ], Response::HTTP_OK);
    }

    public function getProductById($id) 
    {
        try {
            $product = $this->productService->getById($id);
        } catch(ModelNotFoundException $exception) {
            return response()->json([
                "message" => $exception->getMessage(),
            ], Response::HTTP_NOT_FOUND);
        }
        $product["type_name"] = $product->type->name;
        $product["producer_name"] = $product->producer->name;
        return response()->json([
            "data" => $product,
        ], Response::HTTP_OK);
    }

    public function getRelativeProducts($id) {
        try {
            $product = $this->productService->getById($id);
        } catch(ModelNotFoundException $exception) {
            return response()->json([
                "message" => $exception->getMessage(),
            ], Response::HTTP_NOT_FOUND);
        }
        $type_id = $product->type_id;
        $producer_id = $product->producer_id;
        $reletedProduct = $this->productService->getRelativeProducts($type_id, $producer_id, $id);
        return response()->json([
            "data" => $reletedProduct,
        ], Response::HTTP_OK);
    }

    public function store(StoreProductRequest $request) 
    {
        $arr = $request->validated();
        $product = $this->productService->saveProductData($arr);
        return response()->json([
            "data" => $product,
        ], Response::HTTP_OK);
    }

    public function update(UpdateProductRequest $request, $id) 
    {
        $arr = $request->validated();
        try {
            $this->productService->updateProduct($id, $arr);
        } catch(ModelNotFoundException $exception) {
            return response()->json([
                "message" => $exception->getMessage(),
            ], Response::HTTP_NOT_FOUND);
        }
        return response()->json([
            "message" => "Cập nhập thành công",
        ], Response::HTTP_OK);
    }

    public function delete($id) 
    {
        try {
            $this->productService->getById($id);
        } catch(ModelNotFoundException $exception) {
            return response()->json([
                "message" => $exception->getMessage(),
            ], Response::HTTP_NOT_FOUND);
        }
        $this->slideService->deleteSlideByProductId($id);
        $this->productService->delete($id);
        return response()->json([
            "message" => " Xóa thành công",
        ], Response::HTTP_OK);
    }
}