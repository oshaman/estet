<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class KeysSpecialtyPersonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('specialty_person', function (Blueprint $table) {
            $table->foreign('specialty_id')->references('id')->on('specialties')->onDelete('cascade');
            $table->foreign('person_id')->references('id')->on('persons')->onDelete('cascade');
            $table->unique(['specialty_id', 'person_id'], 'specialtyperson')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('specialty_person', function (Blueprint $table) {
            $table->dropForeign(['specialty_id']);
            $table->dropForeign(['person_id']);
            $table->dropUnique('specialtyperson');
        });
    }
}
