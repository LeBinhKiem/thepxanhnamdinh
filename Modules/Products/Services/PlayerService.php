<?php

namespace Modules\Products\Services;

use Modules\Base\Http\Services\BaseService;
use Modules\Products\Models\Players;

class PlayerService extends BaseService
{
    protected $modelName = "players";


    public function getAllWith($filters = [], $orders = [], $relaytionShip = [])
    {
        $items = Players::with($relaytionShip);
        $items = $this->scopeFilterAndSort($items, $filters, $orders);
        $items = $items->paginate(20);

        return $items;
    }
    public function findByIDWith($id, $relaytionShip = [])
    {
        $item = Players::with($relaytionShip)
            ->where("id", $id)
            ->first();

        return $item;
    }
}