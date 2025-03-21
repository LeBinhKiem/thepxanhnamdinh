<?php

namespace Modules\Products\Services;

use Modules\Base\Http\Services\BaseService;
use Modules\Products\Models\BlogCategories;

class BLogCategoriesService extends BaseService
{
    protected $modelName = "blog_categories";

    public function getAllWith($filters = [], $orders = [], $limit = 20){
        $data = BlogCategories::with('parent');
        $data = $this->scopeFilterAndSort($data, $filters,$orders);
        $data = $data->paginate($limit);

        return $data;
    }
}