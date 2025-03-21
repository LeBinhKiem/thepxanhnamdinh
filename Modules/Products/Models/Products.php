<?php

namespace Modules\Products\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Accounts\Models\Admins;

class Products extends Model
{
    protected $table = "products";

    public function category(){
        return $this->hasOne(Categories::class,"id","category_id");
    }
}