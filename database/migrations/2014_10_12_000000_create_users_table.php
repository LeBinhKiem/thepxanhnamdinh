<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('users')){
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name')->unique();
                $table->string('full_name');
                $table->string('logo')->nullable();
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->tinyInteger('status')->default(1);
                $table->string('short_desc')->nullable();
                $table->string('number_phone')->nullable();
                $table->rememberToken();
                $table->timestamps();
            });
        }
    }
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
