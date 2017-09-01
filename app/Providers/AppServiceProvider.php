<?php

namespace Fresh\Estet\Providers;

use Illuminate\Support\ServiceProvider;
use DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /*DB::listen(function ($query) {
//            dump($query);
            echo '<h5>'.$query->sql.'</h5>';
        });*/
        view()->composer('errors::404', function ($view) {
            $article = DB::select('SELECT `id`, `title`, `content`, `path`, `img_title`, `alt`
                                    FROM `articles_view` WHERE `category_id`=17
                                     ORDER BY RAND() LIMIT 1');
            return $view->with('article', $article[0]);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
