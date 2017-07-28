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
            $table->timestamp('expirience')->nullable();
            $table->string('shedule')->nullable();
            $table->text('services')->nullable();
            $table->string('site');
            $table->text('content')->nullable();
            $table->string('photo')->nullable();
            $table->string('alias');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
