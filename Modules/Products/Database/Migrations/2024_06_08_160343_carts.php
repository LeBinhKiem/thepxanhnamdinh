<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Carts extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('carts')) {
            Schema::create('carts', function (Blueprint $table) {
                $table->id();
                $table->integer("user_id");
                $table->integer("product_id");
                $table->integer("amount");
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('carts');
    }
}
