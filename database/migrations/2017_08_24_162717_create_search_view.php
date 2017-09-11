<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSearchView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement( 'CREATE VIEW searchview AS 
            (SELECT `title`, `alias`, `category_id` AS `category`, `content`, `created_at`, `view`, `own` AS `status` FROM `articles`)
            UNION ALL
            (SELECT `title`, `alias`, `category_id` AS `category`, `content`, `created_at`, `view`, (\'blog\') FROM `blogs`)
            UNION ALL
            (SELECT `title`, `alias`, `category` AS `category`, `content`, `created_at`, 1 AS \'view\', `category` FROM `establishments`)
        ' );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement( 'DROP VIEW searchview' );
    }
}