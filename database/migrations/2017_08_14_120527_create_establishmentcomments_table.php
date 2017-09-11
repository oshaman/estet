<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstablishmentcommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('establishmentcomments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('establishment_id')->index();
            $table->unsignedInteger('parent_id')->default(0);
            $table->string('name');
            $table->string('email');
            $table->text('text');
            $table->boolean('approved')->index()->default(false);

            $table->foreign('establishment_id')->references('id')->on('establishments')->onDelete('cascade');
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
        Schema::dropIfExists('establishmentcomments');
    }
}
