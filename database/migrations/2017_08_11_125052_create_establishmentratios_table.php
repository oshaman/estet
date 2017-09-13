<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstablishmentratiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('establishmentratios', function (Blueprint $table) {
            $table->unsignedInteger('establishment_id')->index();
            $table->string('data_key', 32);
            $table->unsignedTinyInteger('value')->index();

            $table->unique(['data_key', 'establishment_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('establishmentratios');
    }
}
