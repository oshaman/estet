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
            $table->string('name');
            $table->string('lastname');
            $table->string('phone');
            $table->string('specialty');
            $table->string('category')->nullable();
            $table->string('job')->nullable();
            $table->string('address')->nullable();
            $table->smallInteger('expirience')->unsigned()->nullable();
            $table->string('shedule')->nullable();
            $table->text('services')->nullable();
            $table->string('site');
            $table->text('content')->nullable();
            $table->string('photo')->nullable();
            $table->boolean('approved')->default(false);
            $table->string('alias');
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
