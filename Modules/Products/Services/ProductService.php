<?php

namespace Modules\Products\Services;

use Modules\Base\Http\Services\BaseService;
use Modules\Products\Models\Products;

class ProductService extends BaseService
{
    protected $modelName = "products";


    public function getAllWith($filters = [], $orders = [], $relaytionShip = [])
    {
        $items = Products::with($relaytionShip);
        $items = $this->scopeFilterAndSort($items, $filters, $orders);
        $items = $items->paginate(20);

        return $items;
    }
    public function findByIDWith($id, $relaytionShip = [])
    {
        $item = Products::with($relaytionShip)
            ->where("id", $id)
            ->first();

        return $item;
    }
}