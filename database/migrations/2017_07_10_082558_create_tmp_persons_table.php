<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTmpPersonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tmp_persons', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->unique();
            $table->string('address');
            $table->string('name');
            $table->string('lastname');
            $table->string('content');
            $table->string('phone');
            $table->string('photo');
            $table->string('category');
            $table->string('site');
            $table->string('job');
            $table->string('shedule');
            $table->smallInteger('expirience')->unsigned();
            $table->boolean('approved')->default(false);
            $table->string('services');
            $table->string('specialty');
            $table->timestamps();

            $table->index('approved');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tmp_persons');
    }
}
