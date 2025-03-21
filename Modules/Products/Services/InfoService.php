<?php

namespace Modules\Products\Services;

use Illuminate\Support\Facades\DB;
use Modules\Base\Http\Services\BaseService;
use Modules\Products\Models\Coaches;

class InfoService extends BaseService
{
    protected $modelName = "info";

    public function getFirst()
    {
        return DB::table("info")->first();
    }
}