<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSlideRequest;
use App\Http\Requests\UpdateSlideRequest;
use App\Services\SlideService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;

class ApiSlideController extends Controller
{

    protected $slideService;

    public function __construct(SlideService $slideService)
    {
        $this->slideService = $slideService;
    }

    public function getSlideByProductId($product_id)
    {
        $slides = $this->slideService->getSlideByProductId($product_id);
        return response()->json([
            "data" => $slides,
        ], Response::HTTP_OK);
    }

    public function store(StoreSlideRequest $request)
    {
        $arr = $request->validated();
        $slide = $this->slideService->store($arr);
        return response()->json([
            "data" => $slide,
        ], Response::HTTP_OK);
    }

    public function update($id, UpdateSlideRequest $request)
    {
        $arr = $request->validated();
        try {
            $this->slideService->update($id, $arr);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                "message" => $exception->getMessage(),
            ], Response::HTTP_NOT_FOUND);
        }
        return response()->json([
            "message" => "Cập nhập thành công",
        ], Response::HTTP_OK);
    }

    public function delete($id) {
        try {
            $this->slideService->deleteSlide($id);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                "message" => $exception->getMessage(),
            ], Response::HTTP_NOT_FOUND);
        }
        return response()->json([
            "message" => "Xóa thành công",
        ], Response::HTTP_OK);
    }
}
