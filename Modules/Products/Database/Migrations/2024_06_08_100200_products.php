<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Products extends Migration
{

    public function up()
    {
        if (!Schema::hasTable('products')) {
            Schema::create('products', function (Blueprint $table) {
                $table->id();
                $table->string("name");
                $table->integer("category_id");
                $table->integer("price");
                $table->tinyInteger("percent_sale")->default(0);
                $table->text("image");
                $table->text("description")->nullable();
                $table->integer("amount")->default(0);
                $table->tinyInteger("vote")->default(0);
                $table->tinyInteger("status")->default(1);
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
