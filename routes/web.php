<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', ['uses' => 'Patient\ArticlesController@index', 'as' => 'main'])->middleware('patient');

Route::match(['post', 'get'], '/captcha', 'CaptchaController@show')->name('captcha');
/**
 * Articles
 */
Route::group(['prefix' => 'statyi', 'middleware' => 'patient'], function () {
    Route::get('/{article_alias?}', 'Patient\ArticlesController@show')->name('articles')->where('article_alias', '[a-zA-Z0-9-_]+');
    Route::get('/teg/{tag_alias}', 'Patient\ArticlesController@tag')->name('articles_tag')->where('tag_alias', '[a-zA-Z0-9-_]+');
    Route::get('kategorii/{cat_alias}', 'Patient\ArticlesController@category')->name('article_cat')->where('cat', '[a-zA-Z0-9-_]+');
});
Route::get('poslednie-novosti', 'Patient\ArticlesController@lastArticles')->name('articles_last')->middleware('patient');
/**
 *  Profile
 */
Route::group(['prefix' => 'profile', 'middleware' => 'auth'], function () {
    Route::get('/', 'ProfileController@index')->name('profile');
    Route::match(['get', 'post'], '/edit', 'ProfileController@update')->name('edit_profile');
    Route::post('cropp-image', 'ProfileController@croppPhoto');
});
/**
 * Horoscope
 */
Route::get('goroscop', 'Patient\HoroscopeController@index')->name('horoscope')->middleware('patient');
/**
 * Static
 */
//Contacts
Route::get('kontakty', 'Static_pageController@contacts')->name('contacts');
//About
Route::get('o-nas', 'Static_pageController@about')->name('about');
//Conditions
Route::get('soglashenie', 'Static_pageController@conditions')->name('conditions');
//partnership
Route::get('partnerstvo', 'Static_pageController@partnership')->name('partnership');
//advertising
Route::get('reklama', 'Static_pageController@advertising')->name('advertising');
//Sitemap
Route::get('karta-saita', 'SitemapController@show')->name('sitemap');

/**
 *  Catalog
 */
Route::group(['prefix'=>'catalog'], function () {
    Route::get('/', 'CatalogController@index')->name('catalog');
    Route::match(['get', 'post'], '/vrachi/{doc?}', 'CatalogController@docs')->name('docs')->where('doc', '[a-zA-Z0-9-_]+');
    Route::match(['get', 'post'], '/kliniki/{establishment_alias?}', 'CatalogController@clinics')->name('clinics')->where('establishment_alias', '[a-zA-Z0-9-_]+');
    Route::match(['get', 'post'], '/distributory/{establishment_alias?}', 'CatalogController@distributors')->name('distributors')->where('establishment_alias', '[a-zA-Z0-9-_]+');
    Route::match(['get', 'post'], '/brendy/{establishment_alias?}', 'CatalogController@brands')->name('brands')->where('establishment_alias', '[a-zA-Z0-9-_]+');
});
/**
 * Switch
 */
Route::post('/switch', 'SwitchController@index')->name('switch');
/**
 * Subscribers
 */
Route::post('/subscribe', 'SubscribersController@add')->name('subscribe');
/**
 * Comments
 */
Route::post('comments', 'CommentsController@store')->name('comments');
/**
 * Doctor's
 */
Route::group(['prefix' => 'doctor', 'middleware' => 'doctor'], function () {
    Route::get('/statyi/{article_alias?}', 'Doctors\DocsController@index')->name('doctors')->where('article_alias', '[a-zA-Z0-9-_]+');
    Route::get('categorii/{cat_alias}', 'Doctors\DocsController@category')->name('docs_cat')->where('cat', '[a-zA-Z0-9-_]+');
    Route::get('/teg/{tag_alias}', 'Doctors\DocsController@tag')->name('docs_tag')->where('tag_alias', '[a-zA-Z0-9-_]+');
    Route::get('/poslednie-novosti/{ids?}', 'Doctors\DocsController@lastArticles')->name('docs_articles_last');
    //  Blog
    Route::group(['prefix' => 'blog'], function () {
        Route::get('/{blog_alias?}', 'Doctors\BlogsController@index')->name('blogs')->where('blog_alias', '[a-zA-Z0-9-_]+');
        Route::get('categorii/{blogs_cat?}', 'Doctors\BlogsController@category')->name('blogs_cat')->where('blogs_cat', '[a-zA-Z0-9-_]+');
        Route::get('/teg/{tag_alias}', 'Doctors\BlogsController@tag')->name('blog_tag')->where('tag_alias', '[a-zA-Z0-9-_]+');
    });
//    Events
    Route::get('meropriyatiya/{event_alias?}', 'Doctors\EventsController@show')->name('events')->where('event_alias', '[a-zA-Z0-9-_]+')->middleware('doctor');
});
/**
 * AdminBlog
 */
Route::group(['prefix'=>'admin-blog', 'middleware'=>'admin_blog'], function () {
    Route::match(['get', 'post'], '/', 'AdminBlog\BlogController@index')->name('admin_blog');
    Route::match(['get', 'post'], 'create', 'AdminBlog\BlogController@create')->name('create_blog');
    Route::match(['get', 'post'], 'edit/{tmp}/{blogid?}', 'AdminBlog\BlogController@edit')->name('edit_blog')->where(['tmp'=>'[0-9]+', 'blogid'=>'[0-9]+']);
    Route::get('destroy/{tmpblog}', 'AdminBlog\BlogController@destroy')->name('destroy_tmp')->where('tmpblog', '[0-9]+');
});
/**
 * SEARCH
 */
Route::group(['prefix' => 'poisk'], function () {
    Route::get('/', 'SearchController@show')->name('search');
});


/**
 *  Admin panel
 */
Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::get('/', ['uses' => 'Admin\IndexController@index', 'as' => 'admin']);
    /**
     *   Admin USERS
     */
    Route::group(['prefix' => 'users'], function () {
        Route::get('/', ['uses' => 'Admin\UsersController@index', 'as' => 'users']);
        Route::match(['get', 'post'], 'edit/{user}', ['uses' => 'Admin\UsersController@edit', 'as' =>'user_update'])->where('user', '[0-9]+');
        Route::get('del/{user}', ['uses'=>'Admin\UsersController@destroy', 'as'=>'delete_user'])->where('user', '[0-9]+');
    });
    /**
     *   Admin PERMISSIONS
     */
    Route::match(['get', 'post'], '/permissions', ['uses' => 'Admin\PermissionsController@index', 'as' => 'permissions']);/**
     /**
     *   Admin GOROSCOP
     */
    Route::match(['get', 'post'], '/goroscop', ['uses' => 'Admin\GoroscopController@index', 'as' => 'admin_goroscop']);
    /**
     *   Admin TAGS
     */
    Route::group(['prefix'=>'tags'], function () {
        Route::match(['get', 'post'], '/', ['uses' => 'Admin\TagsController@index', 'as' => 'tags']);
        Route::match(['get', 'post'], 'edit/{tag}', ['uses' => 'Admin\TagsController@edit', 'as' => 'edit_tags'])->where('tag', '[0-9]+');
        Route::get('delete/{tag}', ['uses' => 'Admin\TagsController@destroy', 'as' => 'delete_tag'])->where('tag', '[0-9]+');
    });
    /**
     *   Admin CATEGORIES
     */
    Route::group(['prefix'=>'cats'], function () {
        Route::match(['get', 'post'], '/', ['uses' => 'Admin\CatsController@index', 'as' => 'cats']);
        Route::match(['get', 'post'], 'edit/{cat}', ['uses' => 'Admin\CatsController@edit', 'as' => 'edit_cats'])->where('cat', '[0-9]+');
    });
    /**
     *   Admin BLOG
     */
    Route::group(['prefix'=>'blogs'], function () {
        Route::match(['get', 'post'], '/', ['uses' => 'Admin\BlogsController@index', 'as' => 'view_blogs']);
        Route::get( 'destroy/{blog}', 'Admin\BlogsController@destroy')->name('destroy_blog')->where('blog', '[0-9]+');
        Route::match(['get', 'post'], 'edit/{blog}', 'Admin\BlogsController@edit')->name('moderate_blog')->where('blog', '[0-9]+');
        Route::match(['get', 'post'], 'add/{tmpblog?}', 'Admin\BlogsController@create')->name('add_blog');
    });
    /**
     *   Admin BLOG CATEGORIES
     */
    Route::group(['prefix'=>'blogcats'], function () {
        Route::match(['get', 'post'], '/', ['uses' => 'Admin\BlogCatsController@index', 'as' => 'blogcats']);
        Route::match(['get', 'post'], 'edit/{blogcat}', ['uses' => 'Admin\BlogCatsController@edit', 'as' => 'edit_blogcats'])->where('blogcat', '[0-9]+');
    });
    /**
     *   Admin SPECIALTIES
     */
    Route::group(['prefix'=>'specialties'], function () {
        Route::match(['get', 'post'], '/', ['uses' => 'Admin\SpecialtiesController@index', 'as' => 'specialties']);
        Route::match(['get', 'post'], 'edit/{spec}', ['uses' => 'Admin\SpecialtiesController@edit', 'as' => 'edit_specialties'])->where('spec', '[0-9]+');
    });
    /**
     * Admin PROFILE
     */
    Route::group(['prefix'=>'profile'], function () {
        //  view profile
        Route::match(['get', 'post'], '/', 'Admin\ProfileController@index')->name('admin_profile');
        //  edit profile
        Route::match(['get', 'post'], 'edit/{user}', 'Admin\ProfileController@edit')->name('edit_profiles');
    });
    /**
     * Admin ESTABLISHMENTS
     */
    Route::group(['prefix'=>'establishments'], function () {
        //  view profile
        Route::match(['get', 'post'], '/', 'Admin\EstablishmentsController@index')->name('admin_establishment');
        //  create new
        Route::match(['get', 'post'], 'create', ['uses'=>'Admin\EstablishmentsController@create', 'as'=>'create_establishments']);
        //  edit profile
        Route::match(['get', 'post'], 'edit/{establishment}', 'Admin\EstablishmentsController@edit')->name('edit_establishment')->where('establishment', '[0-9]+');
        //  delete
        Route::get('del/{establishment}', ['uses'=>'Admin\EstablishmentsController@del', 'as'=>'delete_establishment'])->where('establishment', '[0-9]+');
    });
    /**
     *   Admin ARTICLES
     *
     */
    Route::group(['prefix' => 'articles'], function () {
        //  show articles list
        Route::get('/', ['uses' => 'Admin\ArticlesController@index', 'as' => 'admin_articles']);
        Route::match(['get', 'post'], 'create', ['uses'=>'Admin\ArticlesController@create', 'as'=>'create_article']);
        Route::match(['get', 'post'], 'edit/{article}', ['uses'=>'Admin\ArticlesController@edit', 'as'=>'edit_article'])->where('article', '[0-9]+');
        Route::get('del/{article}', ['uses'=>'Admin\ArticlesController@del', 'as'=>'delete_article'])->where('article', '[0-9]+');

    });
    /**
     * Admin Menus
     */
    Route::match(['post', 'get'], 'menus', 'Admin\MenusController@index')->name('menus');
    /**
     * Admin Country
     */
    Route::group(['prefix'=>'country'], function () {
        Route::get('/', 'Admin\CountriesController@index')->name('country');
        Route::match(['post', 'get'], 'edit/{country}', 'Admin\CountriesController@edit')->name('edit_country')->where('country', '[0-9]+');
        Route::match(['post', 'get'],'add', 'Admin\CountriesController@create')->name('create_country');
    });
    /**
     * Admin City
     */
    Route::group(['prefix'=>'city'], function () {
        Route::match(['post', 'get'], 'select/{id?}', 'Admin\CitiesController@index')->name('city');
        Route::match(['post', 'get'], 'edit/{city}', 'Admin\CitiesController@edit')->name('edit_city')->where('city', '[0-9]+');
        Route::get('del/{city}', 'Admin\CitiesController@destroy')->name('delete_city')->where('city', '[0-9]+');
        Route::match(['post', 'get'],'add', 'Admin\CitiesController@create')->name('create_city');
    });

    /**
     * Admin Premiums
     */
    Route::match(['post', 'get'], 'premium', 'Admin\PremiumsController@index')->name('premium');
    /**
     * Admin Comments
     */
    Route::group(['prefix' => 'comments'], function () {
        Route::match(['post', 'get'], '/', 'Admin\CommentsController@index')->name('admin_comments');
        Route::match(['post', 'get'], 'edit/{comment}', 'Admin\CommentsController@edit')->name('edit_comment');
        Route::get('del/{comment}', 'Admin\CommentsController@destroy')->name('delete_comment');
    });
    /**
     * Admin Events
     */
    Route::group(['prefix' => 'events'], function () {
        Route::match(['post', 'get'], '/show', 'Admin\Events\EventsController@show')->name('events_admin');
        Route::match(['post', 'get'],'add', 'Admin\Events\EventsController@create')->name('create_event');
        Route::match(['post', 'get'], 'edit/{event}', 'Admin\Events\EventsController@edit')->name('edit_event');
        Route::get('del/{event}', 'Admin\Events\EventsController@destroy')->name('delete_event');
        Route::post('slider', 'Admin\Events\EventsController@slider')->name('delete_slider');

        Route::group(['prefix' => 'cats'], function () {
            Route::match(['post', 'get'], '/show', 'Admin\Events\CategoriesController@show')->name('eventcats_admin');
            Route::match(['get', 'post'], 'edit/{eventcat}', ['uses' => 'Admin\Events\CategoriesController@edit', 'as' => 'eventcats_edit'])->where('eventcat', '[0-9]+');
        });
        Route::group(['prefix' => 'organizer'], function () {
            Route::match(['post', 'get'], '/show', 'Admin\Events\OrganizersController@show')->name('organizers_admin');
            Route::match(['get', 'post'], 'edit/{organizer}', ['uses' => 'Admin\Events\OrganizersController@edit', 'as' => 'organizer_edit'])->where('organizer', '[0-9]+');
        });
        Route::group(['prefix' => 'advertising'], function () {
            Route::get('/', 'Admin\Events\AdvertisingsController@show')->name('create_events_slider');
            Route::match(['post', 'get'], 'edit/{eadvertising}', 'Admin\Events\AdvertisingsController@edit')->name('update_events_slider')->where('eadvertising', '[0-9]+');
            Route::get('del/{eadvertising}', 'Admin\Events\AdvertisingsController@del')->name('del_events_slider')->where('eadvertising', '[0-9]+');
        });
    });
    /**
     * Admin SEO
     */
    Route::group(['prefix'=>'seo'], function () {
        Route::get('/', 'Admin\SeoController@index')->name('seo_admin');
        Route::match(['post', 'get'], 'edit/{seo}', 'Admin\SeoController@edit')->name('seo_update')->where('seo', '[0-9]+');
    });
    /**
     * Admin STATIC
     */
    Route::group(['prefix' => 'static'], function () {
        Route::get('/', 'Admin\StaticController@index')->name('admin_static');
        Route::match(['post', 'get'], 'edit/{static}', 'Admin\StaticController@edit')->name('static_update')->where('static', '[0-9]+');
    });
    /**
     * Admin Advertising
     */
    Route::group(['prefix'=>'advertising'], function () {
        Route::get('/', 'Admin\AdvertisingController@index')->name('advertising_admin');
        Route::match(['post', 'get'], 'edit/{advertising}', 'Admin\AdvertisingController@edit')->name('advertising_update')->where('advertising', '[0-9]+');
    });
});
/**
 *  Auth
 */
Auth::routes();
Route::match(['get', 'post'],'/resend', ['uses'=>'Auth\ResendTokenController@index', 'as'=>'resend_activation']);
Route::get('/verifyemail/{token}', 'Auth\RegisterController@verify');

Route::get('/logout', 'Auth\LoginController@logout');
