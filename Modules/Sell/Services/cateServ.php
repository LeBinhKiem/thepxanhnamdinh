<?php

namespace Modules\Sell\Services;

use Modules\Base\Http\Services\BaseService;
use Modules\Products\Models\Products;
use Modules\Products\Enums\ProductEnum;
class cateServ extends BaseService
{
    protected $modelName = "products";


    public function getAllWith($filters = [], $orders = [], $relaytionShip = [])
    {
        $items = Products::with($relaytionShip)->where("status", ProductEnum::STATUS_ACTIVE);
        $items = $this->scopeFilterAndSort($items, $filters, $orders);
        $items = $items->paginate(12);

        return $items;
    }
}