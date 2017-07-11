<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persons', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->unique();
            $table->string('address')->nullable();
            $table->string('name');
            $table->string('lastname');
            $table->text('content')->nullable();
            $table->string('phone');
            $table->string('photo')->nullable();
            $table->string('category')->nullable();
            $table->string('site');
            $table->string('job')->nullable();
            $table->string('shedule')->nullable();
            $table->smallInteger('expirience')->unsigned()->nullable();
            $table->string('alias')->unique();

            $table->timestamps();

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
        Schema::dropIfExists('persons');
    }
}
