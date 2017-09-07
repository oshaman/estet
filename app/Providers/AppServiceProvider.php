<?php

namespace Fresh\Estet\Providers;

use Illuminate\Support\ServiceProvider;
use DB;
use Cache;
use Menu;

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
            $footer = Cache::remember('footer', 24 * 60, function () {
                return view('layouts.footer')->render();
            });

            $status = session('doc');
            if ($status) {
                $nav = Cache::remember('docsMenu', 600, function () use ($status) {
                    $menu = $this->getMenu($status);
                    return view('layouts.nav')->with('menu', $menu)->render();
                });
            } else {
                $nav = Cache::remember('patientMenu', 600, function () use ($status) {
                    $menu = $this->getMenu($status);
                    return view('layouts.nav')->with('menu', $menu)->render();
                });
            }

            return $view->with(['article' => $article[0], 'footer' => $footer, 'nav' => $nav, 'title' => '404']);
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

    /**
     * @param $status boolean
     * @return mixed Menu Instance
     */
    public function getMenu($status)
    {
        $cats = DB::select('SELECT `name`, `alias` FROM ' . ($status ? 'docsmenuview' : 'patientmenuview'));

        return Menu::make('menu', function ($menu) use ($cats, $status) {
            $route = $status ? 'docs_cat' : 'article_cat';
            foreach ($cats as $cat) {
                $menu->add($cat->name, ['route' => [$route, $cat->alias]]);
            }
        });
    }
}
