<?php

namespace Fresh\Estet\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use DB;
use Cache;
use Menu;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof \Illuminate\Session\TokenMismatchException) {

            return redirect()
                ->back()
                ->withInput($request->except('_token'))
                ->withErrors('Время Вашей сессии истекло, повторите запрос.');

        }

        if ($this->isHttpException($e)) {

            $statusCode = $e->getStatusCode();

            switch ($statusCode) {

                case '404':

                    $article = DB::select('SELECT `id`, `title`, `content`, `path`, `img_title`, `alt`
                                    FROM `articles_view` WHERE `category_id`=17
                                     ORDER BY RAND() LIMIT 1');
                    $footer = Cache::remember('footer', 24 * 60, function () {
                        return view('layouts.footer')->render();
                    });

                    $status = \Session::get('doc');

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

                    $css = '<link rel="stylesheet" type="text/css" href="' . asset('css') . '/404.css">';

                    return response()->view('errors.404', [
                        'article' => $article[0],
                        'footer' => $footer,
                        'nav' => $nav,
                        'title' => '404',
                        'css' => $css,
                    ]);
            }
        }

        return parent::render($request, $e);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest(route('login'));
    }

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
