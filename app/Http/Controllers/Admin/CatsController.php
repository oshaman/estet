<?php

namespace Fresh\Estet\Http\Controllers\Admin;

use Fresh\Estet\Http\Requests\Cats;
use Fresh\Estet\Http\Controllers\Admin\AdminController;
use Fresh\Estet\Repositories\CategoriesRepository;
use Gate;
use Validator;

class CatsController extends AdminController
{
    protected $cat_rep;

    public function __construct(CategoriesRepository $rep)
    {
        $this->cat_rep = $rep;
    }

    /**
     * View or Create Catigories
     * @param Request $request
     * @return View
     */
    public function index(Cats $request)
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

        $cats = $this->cat_rep->get(['name', 'id', 'alias'], false, true);
        $this->content = view('admin.cats.content')->with('categories', $cats);

        return $this->renderOutput();
    }

    /**
     * Category update
     * @param Request $request
     * @param $cat cat_id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function edit(Cats $request, $cat)
    {
        if (Gate::denies('UPDATE_CATS')) {
            abort(404);
        }

        if ($request->isMethod('post')) {

            $result = $this->cat_rep->updateCat($request, $cat);
            if ($result) {
                return redirect()->route('cats')->with(['status'=>'Категория обновлена.']);
            } else {

                return redirect()->back()->withErrors(['message'=>'Ошибка изменения категории, повторите попытку позже.']);
            }
        }

        $this->content = view('admin.cats.edit')->with('category', $cat);
        return $this->renderOutput();
    }

}
