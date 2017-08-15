<?php

namespace Fresh\Estet\Http\Controllers\Admin;

use Fresh\Estet\Repositories\CountriesRepository;
use Illuminate\Http\Request;
use Gate;

class CountriesController extends AdminController
{
    protected $repository;

    public function __construct(CountriesRepository $rep)
    {
        $this->repository = $rep;
    }

    public function index()
    {
        if (Gate::denies('UPDATE_GEO')) {
            abort(404);
        }

        $countries = $this->repository->get('*', false, true);

        $this->content = view('admin.geo.country')->with('countries', $countries)->render();

        return $this->renderOutput();
    }

    public function create(Request $request)
    {
        if (Gate::denies('UPDATE_GEO')) {
            abort(404);
        }

        if ($request->isMethod('post')) {

            $result = $this->repository->addCountry($request);
            if(is_array($result) && !empty($result['error'])) {
                return redirect()->back()->withErrors($result['error'])->withInput();
            }
            return redirect()->route('country')->with($result);
        }

        $this->content = view('admin.geo.country_create')->render();

        return $this->renderOutput();

    }

    public function edit(Request $request, $country)
    {
        if (Gate::denies('UPDATE_GEO')) {
            abort(404);
        }

        $this->content = view('admin.geo.country_update')->with('country', $country)->render();

        return $this->renderOutput();
    }

    public function destroy($id)
    {
        if (Gate::denies('UPDATE_GEO')) {
        abort(404);
        }
        dd($id);
    }
}
