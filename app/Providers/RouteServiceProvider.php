<?php

namespace Fresh\Estet\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Fresh\Estet\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //
        parent::boot();

        Route::bind('blog', function ($value) {
            return \Fresh\Estet\Blog::where('id', $value)->first();
        });

        Route::bind('tmpblog', function ($value) {
            return \Fresh\Estet\Tmpblog::where('id', $value)->first();
        });

        Route::bind('article_alias', function ($value) {
                    return \Fresh\Estet\Article::where('alias', $value)->first();
                });

        Route::bind('tag_alias', function ($value) {
                            return \Fresh\Estet\Tag::where('alias', $value)->first();
                        });

        Route::bind('cat_alias', function ($value) {
                            return \Fresh\Estet\Category::where('alias', $value)->first();
                        });
        Route::bind('blogs_cat', function ($value) {
            return \Fresh\Estet\BlogCategory::where('alias', $value)->first();
        });

        Route::model('article', \Fresh\Estet\Article::class);
        Route::model('cat', \Fresh\Estet\Category::class);
        Route::model('blogcat', \Fresh\Estet\BlogCategory::class);
        Route::model('tag', \Fresh\Estet\Tag::class);
        Route::model('establishment', \Fresh\Estet\Establishment::class);
//        Route::model('tag', \Fresh\Estet\Tag::class);


    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
}
