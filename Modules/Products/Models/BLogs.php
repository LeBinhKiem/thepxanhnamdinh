<?php

namespace Modules\Products\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Accounts\Models\Admins;
use Modules\Products\Models\BlogCategories;

class BLogs extends Model
{
    protected $table = "blogs";

    public function blogCategory()
    {
        return $this->hasOne(BlogCategories::class, "id","blog_category_id");
    }
    public function admin()
    {
        return $this->hasOne(Admins::class, "id","admin_id");
    }
}