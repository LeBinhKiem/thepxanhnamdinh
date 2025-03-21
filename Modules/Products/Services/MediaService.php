<?php

namespace Modules\Products\Services;

use Modules\Base\Http\Services\BaseService;
use Modules\Products\Models\Media;

class MediaService extends BaseService
{
    protected $modelName = "medias";


    public function getAllWith($filters = [], $orders = [], $relaytionShip = [])
    {
        $items = Media::with($relaytionShip);
        $items = $this->scopeFilterAndSort($items, $filters, $orders);
        $items = $items->paginate(20);

        return $items;
    }
    public function findByIDWith($id, $relaytionShip = [])
    {
        $item = Media::with($relaytionShip)
            ->where("id", $id)
            ->first();

        return $item;
    }
}