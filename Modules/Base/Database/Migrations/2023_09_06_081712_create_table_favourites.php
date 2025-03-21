<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableFavourites extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('favourites')){
            Schema::create('favourites', function (Blueprint $table) {
                $table->id();
                $table->integer("user_id");
                $table->string("model");
                $table->integer("model_id");
                $table->tinyInteger("status")->default(1);
                $table->timestamps();
                $table->index(['user_id', 'model',"model_id"]);
                $table->index(['user_id', 'model']);
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('favourites');
    }
}
