<?php

namespace Fresh\Estet\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Fresh\Estet\Http\Controllers\Admin\AdminController;
use Fresh\Estet\Repositories\TagsRepository;
use Validator;
use Gate;

class TagsController extends AdminController
{
    protected $tag_rep;

    public function __construct(TagsRepository $rep)
    {
        $this->tag_rep = $rep;
    }

    /**
     * View or Create Tags
     * @param Request $request
     * @return View
     */
    public function index(Request $request)
    {
        if (Gate::denies('UPDATE_TAGS')) {
            abort(404);
        }

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'tag' => ['unique:tags,name', 'required', 'between:5, 32', 'regex:#^[а-яА-ЯёЁ\s-]+$#u']
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }
//dd($request);
            $result = $this->tag_rep->addTag($request);

            if ($result) {
                return back()->with(['status'=>'Новый тэг добавлен.']);
            } else {

                return redirect()->back()->withErrors(['message'=>'Ошибка добавления тэга, повторите попытку позже.']);
            }

        }

        $tags = $this->tag_rep->get(['name', 'id'], false, true);
        $this->content = view('admin.tags.content')->with('tags', $tags);

        return $this->renderOutput();
    }

    /**
     * Tag update
     * @param Request $request
     * @param $tag tag_id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function edit(Request $request, $tag)
    {
        if (Gate::denies('UPDATE_TAGS')) {
            abort(404);
        }

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'tag' => ['unique:tags,name', 'required', 'between:5, 32', 'regex:#^[а-яА-ЯёЁ\s-]+$#u']
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $result = $this->tag_rep->updateTag($request, $tag);
            if ($result) {
                return back()->with(['status'=>'Тэг обновлен.']);
            } else {

                return redirect()->back()->withErrors(['message'=>'Ошибка изменения тэга, повторите попытку позже.']);
            }
        }

        $tag = $this->tag_rep->findById($tag);

        $this->content = view('admin.tags.edit')->with('tag', $tag);
        return $this->renderOutput();
    }
}
