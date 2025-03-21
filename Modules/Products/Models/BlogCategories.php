<?php

namespace Modules\Products\Models;

use Illuminate\Database\Eloquent\Model;

class BlogCategories extends Model
{
    protected $table = "blog_categories";

    public function parent()
    {
        return $this->hasOne(BlogCategories::class, "id", "parent_id");
    }
}