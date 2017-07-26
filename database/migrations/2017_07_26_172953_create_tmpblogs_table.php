<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTmpblogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tmpblogs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->index();
            $table->unsignedInteger('category')->nullable()->default(null);
            $table->text('content')->nullable()->default(null);
            $table->boolean('moderate')->default(false);
            $table->

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
        Schema::dropIfExists('tmpblogs');
    }
}
