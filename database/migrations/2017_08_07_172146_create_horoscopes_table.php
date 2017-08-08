<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHoroscopesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horoscopes', function (Blueprint $table) {
            $table->increments('id');
            $table->text('Aries')->nullable()->default(null);
            $table->text('Taurus')->nullable()->default(null);
            $table->text('Gemini')->nullable()->default(null);
            $table->text('Cancer')->nullable()->default(null);
            $table->text('Leo')->nullable()->default(null);
            $table->text('Virgo')->nullable()->default(null);
            $table->text('Libra')->nullable()->default(null);
            $table->text('Scorpio')->nullable()->default(null);
            $table->text('Sagittarius')->nullable()->default(null);
            $table->text('Capricorn')->nullable()->default(null);
            $table->text('Aquarius')->nullable()->default(null);
            $table->text('Pisces')->nullable()->default(null);
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
        Schema::dropIfExists('horoscopes');
    }
}
