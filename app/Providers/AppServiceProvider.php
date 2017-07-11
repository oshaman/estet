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
    /*public function boot()
    {
        DB::listen(function($query) {
            dump($query);
        });
    }*/

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
