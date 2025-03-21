<?php

namespace Modules\Sell\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $data = [
            "Hoa",
            "Bó hoa",
        ];

        foreach ($data as $value) {
            DB::table("categories")->insert([
                "name" => $value,
                "created_at" => now()->toDateTimeString(),
                "updated_at" => now()->toDateTimeString(),
            ]);
        }
    }
}

#php artisan db:seed --class=Modules\\Sell\\Database\\Seeders\\CategorySeeder