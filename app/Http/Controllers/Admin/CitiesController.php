<?php

namespace Fresh\Estet\Http\Controllers\Admin;

use Fresh\Estet\Repositories\CitiesRepository;
use Fresh\Estet\Repositories\CountriesRepository;
use Illuminate\Http\Request;
use Gate;

class CitiesController extends AdminController
{
    protected $repository;
    protected $countries;

    public function __construct(CountriesRepository $rep, CitiesRepository $cities)
    {
        $this->repository = $cities;
        $this->countries = $rep;
    }

    public function index(Request $request)
    {
        if (Gate::denies('UPDATE_GEO')) {
            abort(404);
        }

        $cities = $this->repository->getCities($request);

        if(is_array($cities) && !empty($cities['error'])) {
            return redirect()->route('city')->withErrors($cities['error'])->withInput();
        }
        if (null !== $cities) $cities->appends(['param' => $request->get('param')])->links();

        $countries = $this->countries->getCountriesSelect();

        $this->content = view('admin.geo.city')->with(['cities'=>$cities, 'countries'=>$countries])->render();

        return $this->renderOutput();
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function create(Request $request)
    {
        if (Gate::denies('UPDATE_GEO')) {
            abort(404);
        }
        if ($request->isMethod('post')) {

            $result = $this->repository->addCity($request);
            if(is_array($result) && !empty($result['error'])) {
                return redirect()->back()->withErrors($result['error'])->withInput();
            }
            return redirect()->route('city')->with($result);
        }
        $countries = $this->countries->getCountriesSelect();

        $this->content = view('admin.geo.city_create')->with('countries', $countries)->render();

        return $this->renderOutput();

    }

    /**
     * @param Request $request
     * @param $city
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function edit(Request $request, $city)
    {
        if (Gate::denies('UPDATE_GEO')) {
            abort(404);
        }

        if ($request->isMethod('post')) {

            $result = $this->repository->updateCity($request, $city);

            if(is_array($result) && !empty($result['error'])) {
                return redirect()->back()->withErrors($result['error'])->withInput();
            }
            return redirect()->route('city')->with($result);
        }

        $countries = $this->countries->getCountriesSelect();

        $this->content = view('admin.geo.city_update')->with(['city' => $city, 'countries' => $countries])->render();

        return $this->renderOutput();
    }

    /**
     * @param $city Instance of City
     * @return $this|\Illuminate\Http\RedirectResponse Status
     */
    public function destroy($city)
    {
        if (Gate::denies('UPDATE_GEO')) {
            abort(404);
        }

        $result = $city->delete();

        if(is_array($result) && !empty($result['error'])) {
            return redirect()->back()->withErrors($result['error'])->withInput();
        }

        return redirect()->route('city')->with(['status'=>'Город удален']);
    }
}
