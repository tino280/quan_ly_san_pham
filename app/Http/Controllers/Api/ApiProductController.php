<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Services\ProductService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApiProductController extends Controller
{

    protected $productService;

    public function __construct(ProductService $productService) 
    {
        $this->productService = $productService;
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
        $product["user"] = $product->user->name;
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
        $user = $request->user();
        $arr['user_id'] = $user->id;
        $product = $this->productService->saveProductData($arr);
        return response()->json([
            "data" => $product,
        ], Response::HTTP_OK);
    }

    public function update(
        UpdateProductRequest $updateProductRequest,
        $id
    )
    {
        $arr_slide = $updateProductRequest
            ->only("slide1", "slide2", "slide3", "slide4",
                "deleteSlide1", "deleteSlide2", "deleteSlide3", "deleteSlide4");
        $arrUpdateProduct = $updateProductRequest
            ->only("name", "type_id", "producer_id", "price", "description", "image_link");
        try {
            $result = $this->productService->updateProduct($id, $arrUpdateProduct, $arr_slide);
            return response()->json([
                "message" => "Cập nhập thành công",
                "data" => $result,
            ], Response::HTTP_OK);
        } catch(ModelNotFoundException $exception) {
            return response()->json([
                "message" => $exception->getMessage(),
                "status" => $exception->getCode(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function delete($id)
    {
        try {
            $this->productService->delete($id);
            return response()->json([
                "message" => " Xóa thành công",
            ], Response::HTTP_OK);
        } catch(ModelNotFoundException $exception) {
            return response()->json([
                "message" => $exception->getMessage(),
            ], Response::HTTP_NOT_FOUND);
        }
    }
}
