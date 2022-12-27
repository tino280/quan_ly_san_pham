<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use http\Exception\UnexpectedValueException;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    use HandlesAuthorization;

   public function delete(User $user, Product $product)
   {
       return $user->checkPermission($user, $product, 'xóa');

   }

    public function update(User $user, Product $product)
    {
        return $user->checkPermission($user, $product, 'cập nhập');
    }
}
