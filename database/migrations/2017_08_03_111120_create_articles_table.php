<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->index();
            $table->string('alias')->unique();
            $table->string('own')->index()->default('patient')->index();
            $table->boolean('approved')->index()->default(false)->index();
            $table->text('content')->nullable()->default(null);

            $table->unsignedInteger('view')->default(1)->index();

            $table->integer('category_id')->unsigned()->default(1);
            $table->foreign('category_id')->references('id')->on('categories');

            $table->text('seo')->nullable()->default(null);

            $table->timestamp('cessation')->nullable()->default(null);
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
        Schema::dropIfExists('articles');
    }
}
