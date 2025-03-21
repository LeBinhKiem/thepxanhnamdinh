<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableReasonLockUser extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('reasons_lock_user')){
            Schema::create('reasons_lock_user', function (Blueprint $table) {
                $table->id();
                $table->integer("user_id");
                $table->string("reason");
                $table->timestamps();
            });
        }
    }
    public function down()
    {
        Schema::dropIfExists('reasons_lock_user');
    }
}
#php artisan migrate --path=Modules/Accounts/Database/Migrations/2023_09_27_074822_create_table_reason_lock_user.php
