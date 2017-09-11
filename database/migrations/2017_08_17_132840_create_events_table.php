<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->index();
            $table->string('alias')->unique();
            $table->unsignedInteger('country_id')->index();
            $table->unsignedInteger('city_id')->index();

            $table->date('start')->index();
            $table->date('stop')->index();

            $table->text('content')->nullable()->default(null);
            $table->text('description')->nullable()->default(null);

            $table->text('seo')->nullable()->default(null);
            $table->unsignedInteger('view')->default(1)->index();
            $table->boolean('approved')->index()->default(false)->index();

            $table->unsignedInteger('organizer_id');
            $table->foreign('organizer_id')->references('id')->on('organizers');

            $table->unsignedInteger('cat_id');
            $table->foreign('cat_id')->references('id')->on('eventscategories');

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
        Schema::dropIfExists('events');
    }
}
