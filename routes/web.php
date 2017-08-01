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

Route::get('/', ['uses'=>'MainController@index', 'as'=>'main']);
Route::get('/home', 'HomeController@index')->name('home');
/**
 *  Profile
 */
Route::group(['prefix' => 'profile', 'middleware' => 'auth'], function () {
    Route::get('/', 'ProfileController@index')->name('profile');
    Route::match(['get', 'post'], '/edit', 'ProfileController@update')->name('edit_profile');

});

/**
 *  Catalog
 */
Route::group(['prefix'=>'catalog'], function () {
    Route::get('/', 'CatalogController@index')->name('catalog');
    Route::get('/vrachi/{doc?}', 'CatalogController@docs')->name('docs')->where('doc', '[a-zA-Z0-9-_]+');
    Route::get('/kliniki/{clinic?}', 'CatalogController@clinics')->name('clinics')->where('clinic', '[a-zA-Z0-9-_]+');
    Route::get('/salony/{salon?}', 'CatalogController@salons')->name('salons')->where('salon', '[a-zA-Z0-9-_]+');
    Route::get('/brendy/{brand?}', 'CatalogController@brands')->name('brands')->where('brand', '[a-zA-Z0-9-_]+');
});
/**
 * Switch
 */
Route::post('/switch', 'SwitchController@index')->name('switch');
/**
 * Doctor's
 */
Route::group(['prefix' => 'doctor', 'middleware' => 'doctor'], function () {
    Route::get('/', 'DocsController@index')->name('docs');
    //  Blog
    Route::group(['prefix' => '/blog'], function () {
        Route::get('/{blog?}', 'BlogsController@index')->name('blogs')->where('blog', '[a-zA-Z0-9-_]+');
        Route::get('category/{blogs_cat?}', 'BlogsController@category')->name('blogs_cat')->where('blogs_cat', '[a-zA-Z0-9-_]+');
    });
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
    Route::match(['get', 'post'], '/permissions', ['uses' => 'Admin\PermissionsController@index', 'as' => 'permissions']);
    /**
     *   Admin TAGS
     */
    Route::group(['prefix'=>'tags'], function () {
        Route::match(['get', 'post'], '/', ['uses' => 'Admin\TagsController@index', 'as' => 'tags']);
        Route::match(['get', 'post'], 'edit/{tag}', ['uses' => 'Admin\TagsController@edit', 'as' => 'edit_tags'])->where('tag', '[0-9]+');
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
        //  edit profile
        Route::match(['get', 'post'], 'edit/{establishment}', 'Admin\ProfileController@edit')->name('edit_establishment');
    });
    /**
     *   Admin ARTICLES
     *
     */
   /* Route::group(['prefix' => 'articles'], function () {
        //  show articles list
        Route::get('/', ['uses' => 'Admin\ArticlesController@index', 'as' => 'admin_articles']);
        //  (editor uses)show articles list sort by CHECKED, DATE or AUTHOR
        Route::match(['get', 'post'], 'selection', ['uses'=>'Admin\ArticlesController@sorted', 'as'=>'selection']);

        Route::match(['get', 'post'], 'create', ['uses'=>'Admin\ArticlesController@create', 'as'=>'create_article']);
        Route::match(['get', 'post'], 'edit/{id}', ['uses'=>'Admin\ArticlesController@edit', 'as'=>'edit_article'])->where('id', '[0-9]+');
        Route::get('del/{id}', ['uses'=>'Admin\ArticlesController@del', 'as'=>'delete_article'])->where('id', '[0-9]+');

    });*/

});

/**
 *  Auth
 */

Auth::routes();
Route::match(['get', 'post'],'/resend', ['uses'=>'Auth\ResendTokenController@index', 'as'=>'resend_activation']);
Route::get('/verifyemail/{token}', 'Auth\RegisterController@verify');

Route::get('/logout', 'Auth\LoginController@logout');
