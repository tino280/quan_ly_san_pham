<?php
namespace App\Repositories\Product;

use App\Models\Product;
use App\Repositories\BaseRepository;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return Product::class;
    }

    public function getAllProductBySearch($arr)
    {
        $query = $this->model->newQuery();

        if (isset($arr['q'])) {
            $q = $arr['q'];
            $query->where('name', 'like', "%$q%");
        }

        if (isset($arr['type_id'])) {
            $type_id = $arr['type_id'];
            $query->where('type_id', $type_id);
        }

        if (isset($arr['producer_id'])) {
            $producer_id = $arr['producer_id'];
            $query->where('producer_id', $producer_id);
        }
        return $query->with('user')->paginate(config('page.number_product'))->withQueryString();
    }

    public function getRelativeProductsData(
        $type_id,
        $producer_id,
        $id
    ) {
        $query = $this->model->newQuery();

        $result = $query
            ->where(function($query) use ($type_id, $producer_id){
                $query
                    ->where('type_id', $type_id)
                    ->where('producer_id', $producer_id);
            })
            ->whereNotIn('id', [$id])
            ->orderBy('price', 'ASC')
            ->limit(config('page.number_related_product'))
            ->get();
        return $result;
    }
}
