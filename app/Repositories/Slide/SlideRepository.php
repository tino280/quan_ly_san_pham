<?php

namespace App\Repositories\Slide;

use App\Models\Slide;
use App\Repositories\BaseRepository;

class SlideRepository extends BaseRepository implements SlideRepositoryInterface {

    public function getModel() 
    {
        return Slide::class;
    }

    public function getSlideByProductId($product_id) 
    {
        $slides = $this->model
            ->where('product_id', $product_id)
            ->orderBy('slot', 'asc')
            ->get();
        return $slides;
    }

    public function deleteSlideByProductId($product_id) 
    {
        $this->model
            ->where('product_id', $product_id)
            ->delete();
    }
}