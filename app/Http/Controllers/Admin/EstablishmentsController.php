<?php

namespace Fresh\Estet\Http\Controllers\Admin;

use Fresh\Estet\Http\Requests\EstablishmentsRequest;
use Fresh\Estet\Repositories\EstablishmentsRepository;
use Gate;

class EstablishmentsController extends AdminController
{
    protected $est_rep;

    public function __construct(EstablishmentsRepository $repository)
    {
        $this->est_rep = $repository;
    }

    public function index()
    {
        if (Gate::denies('UPDATE_ESTABLISHMENT')) {
            abort(404);
        }

        $profiles = $this->est_rep->get(['title', 'phones', 'category', 'id'], false, true);
        $this->content = view('admin.establishment.index')->with('profiles', $profiles)->render();
        return $this->renderOutput();
    }

    public function create(EstablishmentsRequest $request)
    {
        if(Gate::denies('UPDATE_ESTABLISHMENT')) {
            abort(404);
        }

        if ($request->isMethod('post')) {
            dd($request->all());
        }


        $this->template = 'admin.article.admin';
        $parents = $this->est_rep->getParents();

        $this->content = view('admin.establishment.add')->with('parents', $parents)->render();
        return $this->renderOutput();
    }

    public function edit($establishment)
    {
        dd($establishment);
    }

    public function del($establishment)
    {
        dd($establishment);
    }
}
