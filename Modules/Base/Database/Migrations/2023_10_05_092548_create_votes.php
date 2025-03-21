<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVotes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('votes')){
            Schema::create('votes', function (Blueprint $table) {
                $table->id();
                $table->integer("user_id");
                $table->string("model");
                $table->integer("model_id");
                $table->tinyInteger("star")->default(5);
                $table->text("description")->nullable();
                $table->timestamps();
                $table->index(['user_id', 'model',"model_id"]);
                $table->index(['user_id', 'model']);
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('votes');
    }
}

# php artisan migrate --path=Modules/Base/Database/Migrations/2023_10_05_092548_create_votes.php