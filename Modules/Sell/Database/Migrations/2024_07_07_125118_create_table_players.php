<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePlayers extends Migration
{
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("avatar");
            $table->integer("shirt_number");
            $table->dateTime("birth_day");
            $table->integer("height");
            $table->integer("weight");
            $table->string("address");
            $table->string("position");
            $table->string("team");
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('players');
    }
}
