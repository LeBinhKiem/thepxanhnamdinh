<?php

namespace Modules\Products\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Base\Http\Services\BaseService;
use Modules\Products\Enums\BlogCategoriesEnum;
use Modules\Products\Models\BLogs;

class BlogService extends BaseService
{
    protected $modelName = "blogs";

    public function getDataIndex($filters = [], $orders = [])
    {
        $items = BLogs::with("blogCategory", "admin");
        $items = $this->scopeFilterAndSort($items, $filters, $orders);
        $items = $items ->paginate(20);

        $blogCategories = DB::table("blog_categories")
            ->where("status",1)
            ->get();
        $admins = DB::table("admins")
            ->where("status",1)
            ->get();

        $data = [
            "items" => $items,
            "blogCategories" => $blogCategories,
            "admins" => $admins,
        ];

        return $data;
    }

    public function getDataForm()
    {
        $blogCategory = $this->__getBlogCategories();

        $viewData = [
            "blogCategories" => $blogCategory
        ];

        return $viewData;
    }

    public function findByIdWith($id)
    {
        $data = BLogs::with("admin")
            ->where("id", $id)
            ->first();

        $tags = explode("|", $data->tag);
        foreach ($tags as $index => $tag) {
            $tags[]["value"] = $tag;
            unset($tags[$index]);
        }

        $data->tag = json_encode(array_values($tags));

        return $data;
    }

    private function __getBlogCategories(){
        $items = DB::table("blog_categories")
            ->select("id","name", "parent_id")
            ->where("status", BlogCategoriesEnum::STATUS_ACTIVE)
            ->get();

        $data = [];

        foreach ($items as $item)
        {
            if ($item->parent_id > 0)
            {
                $data[$item->parent_id]['child'][] = (array) $item;
            }
            else
            {
                $data[$item->id] = (array) $item;
            }
        }

        return $data;
    }

    public function getAllWith($filters = [], $orders = [], $with = [], $limit = 20){
        $data = BLogs::with($with);
        $data = $this->scopeFilterAndSort($data, $filters,$orders);
        $data = $data->paginate($limit);

        return $data;
    }

    public function getBlogCategoríes()
    {
        $items = DB::table("blog_categories")
            ->select("id","name", "parent_id")
            ->where("status", 1)
            ->orderBy("parent_id")
            ->get();

        $data = [];

        foreach ($items as $item)
        {
            if ($item->parent_id > 0)
            {
                $data[$item->parent_id]['child'][] = (array) $item;
            }
            else
            {
                $data[$item->id] = (array) $item;
            }
        }

        return $data;
    }
}