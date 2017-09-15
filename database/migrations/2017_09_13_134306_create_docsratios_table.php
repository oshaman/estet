<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocsratiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('docsratios', function (Blueprint $table) {
            $table->unsignedInteger('doc_id')->index();
            $table->string('data_key', 32);
            $table->unsignedTinyInteger('value')->index();

            $table->unique(['data_key', 'doc_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('docsratios');
    }
}
