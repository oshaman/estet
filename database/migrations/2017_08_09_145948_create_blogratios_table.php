<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogratiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogratios', function (Blueprint $table) {
            $table->string('blog_id')->references('id')->on('blogs')->onDelete('cascade');
            $table->string('key');
            $table->unsignedSmallInteger('value');

            $table->unique(['blog_id', 'key']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blogratios');
    }
}
