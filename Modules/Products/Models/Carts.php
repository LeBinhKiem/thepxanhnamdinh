<?php

namespace Modules\Products\Models;

use Illuminate\Database\Eloquent\Model;

class Carts extends Model
{
    protected $table = "carts";

    public function product()
    {
        return $this->hasOne(Products::class, "id", "product_id");
    }
}