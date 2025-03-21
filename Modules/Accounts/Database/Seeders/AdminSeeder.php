<?php

namespace Modules\Accounts\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $database = DB::table("admins");
        $database->truncate();

        $data = [
            "name"          => "Pham Dinh Thang",
            "email"         => "admin@gmail.com",
            "phone_number"  => "0123456789",
            "skype"         => "",
            "sex"           => "2",
            "password"      => bcrypt("12345678"),
            "status"        => 1,
            "created_at"    => now()->toDateTimeString(),
            "updated_at"    => now()->toDateTimeString(),
        ];

        $database->insertOrIgnore($data);
//
//        for ($i = 0; $i < 100; $i++) {
//            $data = [
//                "name"          => vnfaker()->fullname(),
//                "email"         => vnfaker()->email(),
//                "phone_number"  => vnfaker()->mobilephone(),
//                "skype"         => vnfaker()->email(),
//                "sex"           => random_int(0,2),
//                "password"      => bcrypt("12345678"),
//                "status"        => random_int(0,1),
//                "created_at"    => now()->toDateTimeString(),
//                "updated_at"    => now()->toDateTimeString(),
//            ];
//
//            $database->insertOrIgnore($data);
//        }
    }
}

#php artisan db:seed --class=Modules\\Accounts\\Database\\Seeders\\AdminSeeder