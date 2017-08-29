<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement( 'CREATE VIEW articles_view AS 
            (SELECT
             articles.id, articles.title, articles.alias, articles.created_at, articles.view, articles.category_id,
              images.path, images.title as img_title, images.alt, categories.name
               FROM `articles`
                LEFT JOIN `images` ON articles.id = images.article_id
                LEFT JOIN `categories` ON articles.category_id = categories.id
                WHERE `approved` =1 AND articles.created_at <= NOW() AND `own` = \'patient\')
        ' );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement( 'DROP VIEW articles_view' );
    }
}
