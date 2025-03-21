<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlog extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('blogs')) {
            Schema::create('blogs', function (Blueprint $table) {
                $table->id();
                $table->integer("admin_id");
                $table->string("title");
                $table->string("slug")->unique();
                $table->string("logo")->nullable();
                $table->integer("blog_category_id");
                $table->integer("view")->default(0);
                $table->text("content")->nullable();
                $table->string("short_description")->nullable();
                $table->string("tag")->nullable();
                $table->tinyInteger("status")->default(1);
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('blogs');
    }
}
#php artisan migrate:rollback --path=Modules/Products/Database/Migrations/2023_09_28_034736_create_blog.php