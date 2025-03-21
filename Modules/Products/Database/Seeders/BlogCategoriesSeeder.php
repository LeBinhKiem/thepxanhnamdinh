<?php

namespace Modules\Products\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BlogCategoriesSeeder extends Seeder
{
    public function run(){
        DB::table("blog_categories")->truncate();
        $datas = include(__DIR__."/../Data/blog_categories.php");

        foreach ($datas as $data){
            $data["slug"] = Str::slug($data["name"]);
            $data["created_at"] = now()->toDateTimeString();
            $data["updated_at"] = now()->toDateTimeString();

            DB::table("blog_categories")->insertOrIgnore($data);
        }
    }
}
#php artisan db:seed --class=Modules\\Keywords\\Database\\Seeders\\BlogCategoriesSeeder