<?php

namespace Fresh\Estet\Http\Controllers\Admin;

use Fresh\Estet\Http\Requests\TagsRequest;
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
    public function index(TagsRequest $request)
    {
        if (Gate::denies('UPDATE_TAGS')) {
            abort(404);
        }

        if ($request->isMethod('post')) {
            //dd($request);
            $result = $this->tag_rep->addTag($request);

            if ($result) {
                return back()->with(['status'=>'Новый тэг добавлен.']);
            } else {

                return redirect()->back()->withErrors(['message'=>'Ошибка добавления тэга, повторите попытку позже.']);
            }

        }

        $tags = $this->tag_rep->get(['name', 'id', 'alias'], false, true);
        $this->content = view('admin.tags.content')->with('tags', $tags);

        return $this->renderOutput();
    }

    /**
     * Tag update
     * @param Request $request
     * @param $tag tag_id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function edit(TagsRequest $request, $tag)
    {
        if (Gate::denies('UPDATE_TAGS')) {
            abort(404);
        }

        if ($request->isMethod('post')) {

            $result = $this->tag_rep->updateTag($request, $tag);
            if ($result) {
                return redirect()->route('tags')->with(['status'=>'Тэг обновлен.']);
            } else {

                return redirect()->back()->withErrors(['message'=>'Ошибка изменения тэга, повторите попытку позже.']);
            }
        }

        $this->content = view('admin.tags.edit')->with('tag', $tag);
        return $this->renderOutput();
    }

    public function destroy($tag)
    {
        if (Gate::denies('UPDATE_TAGS')) {
            abort(404);
        }

        $result = $this->tag_rep->deleteTag($tag);
        if(is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }
        return redirect()->route('tags')->with($result);

    }
}
