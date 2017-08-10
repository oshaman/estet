<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstablishmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('establishments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->unique();
            $table->string('alias')->unique();
            $table->string('logo');
            $table->string('address');
            $table->string('phones');
            $table->string('site');
            $table->float('ratio', 2, 1)->nullable()->default(null);
            $table->unsignedInteger('parent')->nullable()->default(null)->index();
            $table->text('extra')->nullable()->default(null);
            $table->text('services')->nullable()->default(null);
            $table->text('about');
            $table->enum('category', ['clinic', 'brand', 'distributor']);
            $table->string('spec')->nullable()->default(null);

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
        Schema::dropIfExists('establishments');
    }
}
