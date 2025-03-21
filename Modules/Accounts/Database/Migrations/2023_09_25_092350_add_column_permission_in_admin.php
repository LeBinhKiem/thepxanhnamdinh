<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnPermissionInAdmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('admins',"permission")){
            Schema::table('admins', function (Blueprint $table) {
                $table->tinyInteger("permission")->after("sex")->default(1);
            });
        }
    }

    public function down()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn("permission");
        });
    }
}

#php artisan migrate:rollback --path=Modules/Accounts/Database/Migrations/2023_09_25_092350_add_column_permission_in_admin.php
