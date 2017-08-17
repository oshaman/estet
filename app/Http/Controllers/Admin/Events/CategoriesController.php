<?php

namespace Fresh\Estet\Http\Controllers\Admin\Events;

use Fresh\Estet\Http\Controllers\Admin\AdminController;
use Fresh\Estet\Http\Requests\EventcatsRequest;
use Fresh\Estet\Repositories\EventCategoriesRepository;
use Gate;

class CategoriesController extends AdminController
{
    protected $cat_rep;

    public function __construct(EventCategoriesRepository $rep)
    {
        $this->template = 'admin.events.index';
        $this->cat_rep = $rep;
    }

    /**
     * View or Create Catigories
     * @param Request $request
     * @return View
     */
    public function show(EventcatsRequest $request)
    {
        if (Gate::denies('UPDATE_EVENTS')) {
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
        $this->content = view('admin.events.cats.content')->with('categories', $cats);

        return $this->renderOutput();
    }

    /**
     * Category update
     * @param Request $request
     * @param $cat cat_id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function edit(EventcatsRequest $request, $cat)
    {
        if (Gate::denies('UPDATE_EVENTS')) {
            abort(404);
        }

        if ($request->isMethod('post')) {

            $result = $this->cat_rep->updateCat($request, $cat);

            if(is_array($result) && !empty($result['error'])) {
                return redirect()->back()->withErrors($result['error'])->withInput();
            }

            if ($result) {
                return redirect()->route('eventcats_admin')->with(['status'=>'Категория обновлена.']);
            } else {

                return redirect()->back()->withErrors(['message'=>'Ошибка изменения категории, повторите попытку позже.']);
            }
        }

        $this->content = view('admin.events.cats.edit')->with('category', $cat);
        return $this->renderOutput();
    }
}
