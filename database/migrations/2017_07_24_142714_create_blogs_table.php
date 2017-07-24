<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {

            $table->increments('id');
            $table->string('title')->index();
            $table->string('alias')->unique();
            $table->boolean('approved')->default(false);
            $table->text('content');

            $table->integer('img_id')->unsigned()->default(1);
            $table->foreign('img_id')->references('id')->on('blog_imgs');

            $table->integer('user_id')->unsigned()->default(1);
            $table->foreign('user_id')->references('id')->on('users');

            $table->integer('category_id')->unsigned()->default(1);
            $table->foreign('category_id')->references('id')->on('blog_categories');

            $table->integer('seo_id')->unsigned()->default(1);
            $table->foreign('seo_id')->references('id')->on('seos');

            $table->timestamp('cessation')->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blogs');
    }
}
