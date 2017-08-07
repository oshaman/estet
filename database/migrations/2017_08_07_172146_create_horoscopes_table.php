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
            $table->text('Aries');
            $table->text('Taurus');
            $table->text('Gemini');
            $table->text('Cancer');
            $table->text('Leo');
            $table->text('Virgo');
            $table->text('Libra');
            $table->text('Scorpio');
            $table->text('Sagittarius');
            $table->text('Capricorn');
            $table->text('Aquarius');
            $table->text('Pisces');
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
