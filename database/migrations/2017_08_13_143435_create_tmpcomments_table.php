<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTmpcommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tmpcomments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('article_id')->index();
            $table->unsignedInteger('parent_id')->default(0);
            $table->string('name');
            $table->string('email');
            $table->text('text');

            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
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
        Schema::dropIfExists('tmpcomments');
    }
}
