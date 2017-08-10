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

    public function index(EstablishmentsRequest $request)
    {
        if (Gate::denies('UPDATE_ESTABLISHMENT')) {
            abort(404);
        }


        $data = $request->except('_token');
        if (!empty($data['param'])) {
            $data['value'] = $data['value'] ?? null;
            switch ($data['param']) {
                case 1:
                    $profiles[] = $this->est_rep->one($data['value']);
                    break;
                case 2:
                    $profiles[] = $this->est_rep->findByTitle($data['value']);
                    break;
                default:
                    $profiles = $this->est_rep->get(['title', 'phones', 'category', 'id'], false, true);
            }
        } else {
            $profiles = $this->est_rep->get(['title', 'phones', 'category', 'id'], false, true);
        }

        $this->content = view('admin.establishment.index')->with('profiles', $profiles)->render();
        return $this->renderOutput();
    }

    public function create(EstablishmentsRequest $request)
    {
        if(Gate::denies('UPDATE_ESTABLISHMENT')) {
            abort(404);
        }

        if ($request->isMethod('post')) {

            $result = $this->est_rep->addEstablishment($request);
            if(is_array($result) && !empty($result['error'])) {
                return back()->withErrors($result);
            }
            return redirect()->route('admin_establishment')->with($result);
        }


        $this->template = 'admin.article.admin';
        $parents = $this->est_rep->getParents();

        $this->content = view('admin.establishment.add')->with('parents', $parents)->render();
        return $this->renderOutput();
    }

    public function edit(EstablishmentsRequest $request, $establishment)
    {
        if(Gate::denies('UPDATE_ESTABLISHMENT')) {
            abort(404);
        }

        if ($request->isMethod('post')) {

            $result = $this->est_rep->updateEstablishment($request, $establishment);
            if(is_array($result) && !empty($result['error'])) {
                return back()->withErrors($result);
            }
            return redirect()->route('admin_establishment')->with($result);
        }

        $this->template = 'admin.article.admin';
        $parents = $this->est_rep->getParents();

        $establishment = $this->est_rep->convertParams($establishment);

//        dd($establishment->services);

        $this->content = view('admin.establishment.edit')->with(['parents' => $parents, 'establishment' => $establishment])->render();
        return $this->renderOutput();

    }

    public function del($establishment)
    {
        if (Gate::denies('UPDATE_ESTABLISHMENT')) {
            abort(404);
        }

        $result = $this->est_rep->deleteEstablishment($establishment);

        if(is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }
        return redirect()->route('admin_establishment')->with($result);
    }
}
