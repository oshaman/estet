<?php

namespace Fresh\Estet\Http\Controllers\Admin;

use Fresh\Estet\Http\Controllers\Admin\AdminController;
use Fresh\Estet\Http\Requests\BlogCatsRequest;
use Fresh\Estet\Repositories\BlogCategoriesRepository;
use Gate;
use Validator;

class BlogCatsController extends AdminController
{
    protected $cat_rep;

    public function __construct(BlogCategoriesRepository $rep)
    {
        $this->cat_rep = $rep;
    }

    /**
     * View or Create Catigories
     * @param Request $request
     * @return View
     */
    public function index(BlogCatsRequest $request)
    {
        if (Gate::denies('UPDATE_CATS')) {
            abort(404);
        }

        if ($request->isMethod('post')) {

            $result = $this->cat_rep->addCat($request);

            if ($result) {
                return back()->with(['status'=>'Новая категория добавлена.']);
            } else {

                return redirect()->back()->withErrors(['message'=>'Ошибка добавления категории, повторите попытку позже.']);
            }

        }

        $cats = $this->cat_rep->get(['name', 'alias', 'id'], false, true);
        $this->content = view('admin.blogcats.content')->with('categories', $cats);

        return $this->renderOutput();
    }

    /**
     * Category update
     * @param Request $request
     * @param $cat cat_id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function edit(BlogCatsRequest $request, $cat)
    {
        if (Gate::denies('UPDATE_CATS')) {
            abort(404);
        }

        if ($request->isMethod('post')) {

            $result = $this->cat_rep->updateCat($request, $cat);
            if ($result) {
                return redirect()->route('blogcats')->with(['status'=>'Категория обновлена.']);
            } else {

                return redirect()->back()->withErrors(['message'=>'Ошибка изменения категории, повторите попытку позже.']);
            }
        }

        $this->content = view('admin.blogcats.edit')->with('category', $cat);
        return $this->renderOutput();
    }
}
