<?php

namespace Fresh\Estet\Http\Controllers\Admin;

use Fresh\Estet\Repositories\SeoRepository;
use Illuminate\Http\Request;
use Gate;


class SeoController extends AdminController
{

    public function index(SeoRepository $repository)
    {
        if (Gate::denies('UPDATE_SEO')) {
            abort(404);
        }

        $seos = $repository->get(['id', 'uri']);
        $this->content = view('admin.seo.show')->with(['seos' => $seos])->render();
        return $this->renderOutput();
    }

    public function edit(SeoRepository $repository, Request $request, $seo=false)
    {
        if (Gate::denies('UPDATE_SEO')) {
            abort(404);
        }
        if ($request->isMethod('post')) {
            $result = $repository->updateSeo($request, $seo);
//dd($result);
            if(is_array($result) && !empty($result['error'])) {
                return back()->withErrors($result['error']);
            }
            return redirect()->route('seo_admin')->with($result);
        }

        $this->content = view('admin.seo.edit')->with(['seo' => $seo])->render();
        return $this->renderOutput();

    }
}
