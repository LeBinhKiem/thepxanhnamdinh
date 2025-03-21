<?php

namespace Modules\Base\Http\Services;

use Illuminate\Support\Facades\DB;
use Modules\Base\Http\Traits\FilterScopeTrait;

class BaseService
{
    protected $modelName;

    use FilterScopeTrait;
    public function findByID($id){
        return DB::table($this->modelName)
            ->where("id", $id)
            ->first();
    }

    public function getAll($filters = [], $orders = [], $limit = 20){
        $data = DB::table($this->modelName);
        $data = $this->scopeFilterAndSort($data, $filters,$orders);
        $data = $data->paginate($limit);

        return $data;
    }

    public function insert($array = []){
        $array["created_at"] = now()->toDateTimeString();
        $array["updated_at"] = now()->toDateTimeString();

        return DB::table($this->modelName)->insert($array);
    }
    public function updateByID($id,$array = []){
        $array["updated_at"] = now()->toDateTimeString();
        return DB::table($this->modelName)
            ->where("id", $id)
            ->update($array);
    }
    public function deleteByID($id){
        return DB::table($this->modelName)
            ->where("id", $id)
            ->delete();
    }
}