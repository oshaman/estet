<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocsmenuview extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement( 'CREATE VIEW docsmenuview AS SELECT * FROM `categories` WHERE id in (SELECT `category_id` FROM `menus` WHERE `own`=\'docs\')' );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement( 'DROP VIEW docsmenuview' );
    }
}
