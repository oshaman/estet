<?php

namespace Fresh\Estet\Http\Controllers\Admin;

use Fresh\Estet\Repositories\Static_pageRepository;
use Illuminate\Http\Request;
use Gate;

class StaticController extends AdminController
{
    public function index(Static_pageRepository $repository)
    {
        if (Gate::denies('UPDATE_STATIC')) {
            abort(404);
        }

        $pages = $repository->get(['id', 'title', 'text', 'own']);
        $this->content = view('admin.static.show')->with(['pages' => $pages])->render();
        return $this->renderOutput();
    }

    public function edit(Static_pageRepository $repository, Request $request, $static_page=false)
    {
        if (Gate::denies('UPDATE_STATIC')) {
            abort(404);
        }
        if ($request->isMethod('post')) {
            $result = $repository->updateStatic_page($request, $static_page);

            if (is_array($result) && !empty($result['error'])) {
                return back()->withErrors($result['error']);
            }
            return redirect()->route('admin_static')->with($result);
        }
        $this->template = 'admin.article.admin';
        $static_page->seo = $repository->convertSeo($static_page->seo);
        $this->content = view('admin.static.edit')->with(['page' => $static_page])->render();
        return $this->renderOutput();
    }
}
