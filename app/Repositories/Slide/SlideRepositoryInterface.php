<?php

namespace App\Repositories\Slide;

use App\Repositories\RepositoryInterface;

interface SlideRepositoryInterface extends RepositoryInterface
{
    public function getSlideByProductId($product_id);
    public function getSlideByProductIdAndSlot($product_id, $slot);
    public function deleteSlideByProductId($product_id);
}
