<?php

namespace App\Services;

use App\Repositories\Slide\SlideRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;

class SlideService
{
    protected $slideRepo;

    public function __construct(SlideRepositoryInterface $slideRepo)
    {
        $this->slideRepo = $slideRepo;
    }

    public function getSlideByProductId($product_id)
    {
        $result = $this->slideRepo->getSlideByProductId($product_id);
        if (!count($result)) {
            throw new ModelNotFoundException("Không có slide");
        }
        return $result;
    }

    public function getById($id)
    {
        $result = $this->slideRepo->find($id);
        return $result;
    }

    public function store($arr)
    {
        $path = $arr["image"];
        $slide_name = $path->hashName();
        $arr["image"] = $slide_name;
        $product_id = $arr["product_id"];
        $result = $this->slideRepo->save($arr);
        $path->move(public_path("image/slide/$product_id"), $slide_name);
        return $result;
    }

    public function update($id, $arr)
    {
        $slide = $this->slideRepo->find($id);
        if (!$slide) {
            throw new ModelNotFoundException("Không có slide");
        }
        $name = $slide->image;
        $product_id = $slide->product_id;
        File::delete(public_path("image/slide/$product_id/$name"));
        $path = $arr["image"];
        $slide_name = $path->hashName();
        $arr["image"] = $slide_name;
        $result = $this->slideRepo->update($id, $arr);
        $path->move(public_path("image/slide/$product_id"), $slide_name);
        return $result;
    }

    public function deleteSlide($id)
    {
        $slide = $this->slideRepo->find($id);
        if (!$slide) {
            throw new ModelNotFoundException("Không có ảnh slide");
        }
        $name = $slide->image;
        $product_id = $slide->product_id;
        File::delete(public_path("image/slide/$product_id/$name"));
        $this->slideRepo->delete($id);
    }

    public function deleteSlideByProductId($product_id)
    {
        File::deleteDirectory(public_path("image/slide/$product_id"));
        $this->slideRepo->deleteSlideByProductId($product_id);
    }

    public function createOrUpdate($slide_id = null, $arr) {
        if ($slide_id = null) {
            $this->store($arr);
        } else {
            $slide = $this->slideRepo->find($slide_id);
            if (!$slide) {
                throw new ModelNotFoundException("Không có slide");
            }
            $this->slideRepo->update($slide_id, $arr);
        }
    }
}
