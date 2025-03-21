<?php

namespace Modules\Products\Services;

use Modules\Base\Http\Services\BaseService;
use Modules\Products\Models\Coaches;
use Modules\Products\Models\Players;

class CoachService extends BaseService
{
    protected $modelName = "coaches";


    public function getAllWith($filters = [], $orders = [], $relaytionShip = [])
    {
        $items = Coaches::with($relaytionShip);
        $items = $this->scopeFilterAndSort($items, $filters, $orders);
        $items = $items->paginate(20);

        return $items;
    }
    public function findByIDWith($id, $relaytionShip = [])
    {
        $item = Coaches::with($relaytionShip)
            ->where("id", $id)
            ->first();

        return $item;
    }
}